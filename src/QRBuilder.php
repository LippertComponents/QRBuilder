<?php
namespace LCI\MODX\QRBuilder;

use Endroid\QrCode\QrCode;
use DateTime;
use modX;
use PDO;

/**
 * @package qrbuilder
 */
class QRBuilder {
    /**
     * Constructs the Qrbuilder object
     *
     * @param modX &$modx A reference to the modX object
     * @param array $config An array of configuration options
     */
    function __construct(modX $modx, array $config = array()) {
        $this->modx = $modx;

        $basePath = $this->modx->getOption('patents.core_path', $config, $this->modx->getOption('core_path').'vendor/lci/modx-qrbuilder/src/');
        $assetsUrl = $this->modx->getOption('qrbuilder.assets_url', $config,$this->modx->getOption('assets_url').'components/qrbuilder/');
        $assetsPath = $this->modx->getOption('qrbuilder.assets_path', $config,$this->modx->getOption('assets_path').'components/qrbuilder/');
        $qrCodeDir = $this->modx->getOption('qrbuilder.qr_code_dir', $config, 'images/qr/');
        
        $this->config = array_merge(array(
            'basePath' => $basePath,
            'corePath' => $basePath,
            'modelPath' => $basePath.'model/',
            'processorsPath' => $basePath.'processors/',
            'templatesPath' => $basePath.'templates/',
            'chunksPath' => $basePath.'elements/chunks/',
            'qrCodeDir' => $qrCodeDir,
            'qrCodePath' => $assetsPath.$qrCodeDir,
            'jsUrl' => $assetsUrl.'js/',
            'cssUrl' => $assetsUrl.'css/',
            'assetsUrl' => $assetsUrl,
            'connectorUrl' => $assetsUrl.'connector.php',
            'qrCodeUrl' => $assetsUrl.$qrCodeDir
        ),$config);

        $this->modx->addPackage('qrbuilder',$this->config['modelPath']);
    }

    /**
     * @param string $url
     * @param string $file_name
     * @return array
     */
    public function buildQRCode($url, $file_name)
    {
        // filename:
        $png_file = $this->config['qrCodePath'].$file_name.'.png';
        $svg_file = $this->config['qrCodePath'].$file_name.'.svg';

        $qrCode = new QRcode($url);
        $qrCode->setSize(100);
        $qrCode->setWriterByName('png');
        $qrCode->writeFile($png_file);

        $qrCode = new QRcode($url);
        $qrCode->setSize(800);
        $qrCode->setWriterByName('svg');
        $qrCode->writeFile($svg_file);

        return [
            'png' => $this->config['qrCodeDir'].$file_name.'.png',
            'svg' => $this->config['qrCodeDir'].$file_name.'.svg',
        ];
    }
    
    /**
     * Redirect
     * @param string $uri_search
     * @param string $context_key
     * @return VOID
     */
    public function redirect($uri_search, $context_key='web')
    {
        // search db:
        $qrcode = $this->modx->getObject(
            'Qrcodes',
            [
                'short_link' => $uri_search,
                'context_key' => $context_key,
                'active' => true,
            ]
        );

        if (!empty($qrcode) && is_object($qrcode)) {
            // if valid build URL and send:
            $start = $this->getTime($qrcode->get('start_date'));
            
            $end = $this->getTime($qrcode->get('end_date'));
            
            $now = time();// @TODO system setting time offset
            $use_end = $qrcode->get('use_end_date');
            
            if ( $start > $now || ($end < $now && $use_end)) {
                $qrcode->set('active', 0);
                // $qrcode->save();
                return;
            }
            // record stats:
            $qrcode->set('hits', $qrcode->get('hits')+1);
            $qrcode->save();

            $sql = "INSERT INTO modx_qrcode_stats
                (
                    qrcode_id, 
                    date, 
                    day_hits
                )
                VALUES 
                (
                    :qrcode_id, 
                    :date, 
                    :day_hits
                ) 
                ON DUPLICATE KEY 
                UPDATE 
                    day_hits=day_hits+1
                ; ";
            $sth = $this->modx->prepare($sql);
            
            $id = $qrcode->get('id');
            $sth->bindParam(':qrcode_id', $id, PDO::PARAM_INT);
            
            $date = date('Y-m-d', $now);
            $sth->bindParam(':date', $date, PDO::PARAM_STR);
            $hits = 1;
            $sth->bindParam(':day_hits', $hits, PDO::PARAM_INT);
            
            $sth->execute();
            $error = $sth->errorInfo();
            
            if ( $error[0] != '00000' ) {
                $this->modx->log(modX::LOG_LEVEL_ERROR,'[QRBuilder] Error recording stat data: '.print_r($sth->errorInfo(), true) );
            }
            
            // build URL:
            $url = $qrcode->get('destination_url');
            /** @var string $page_fragment */
            $page_fragment = null;
            if ( strpos($url, '#') !== false ) {
                $page_fragment = substr($url, strpos($url, '#')+1);
                $url = substr($url, 0, strpos($url, '#'));
            }

            $params = json_decode($qrcode->get('build_url_params'), true);
            foreach ($params as $key => $value) {
                if ( empty($value) && $value !== 0 ) {
                    unset($params[$key]);
                }
            }
            if ( is_numeric($url) ) {
                // Assume MODX Resource
                $url = $this->modx->makeUrl($url, '', $params, 'full');
            } else {
                $str = http_build_query($params);
                
                $pos = strpos($url, '?');
                if ( $pos > 0 ) {
                    if ( $pos == strlen($url)) {
                        // it is at the end
                        $url .= $str;
                    } else {
                        $url .= '&'.$str;
                    }
                } else {
                    $url .= '?'.$str;
                }
            }
            if ( !is_null($page_fragment) ) {
                $url .= '#'.$page_fragment;
            }
            
            // now send:
            /** @var string $http - see http://php.net/manual/en/function.header.php#92305 */
            $http = 'HTTP/1.1';
            if ( isset($_SERVER["SERVER_PROTOCOL"]) ) {
                $http = $_SERVER["SERVER_PROTOCOL"];
            }
            $options = ['responseCode' => $http.' 302 Found'];
            
            $redirect_type = $qrcode->get('redirect_type');
            if ( $redirect_type == 301 ){
                $options = ['responseCode' => $http.' 301 Moved Permanently'];
            }

            $this->modx->sendRedirect($url, $options);
        }
        
        return;
    }
    
    /**
     * Utilities
     * @param (String) $date
     * @param (String) $format ~ the format of the date being sent
     * @return (INT) $timestamp
     */
    public function getTime($date, $format='Y-m-d')
    {
        $tmpDate = DateTime::createFromFormat($format, $date );
        $time = $tmpDate->getTimestamp();
        
        return $time;
    }
}