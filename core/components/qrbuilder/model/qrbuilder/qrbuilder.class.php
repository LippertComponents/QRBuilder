<?php
/**
 * @package qrbuilder
 */
class Qrbuilder {
    /**
     * Constructs the Qrbuilder object
     *
     * @param modX &$modx A reference to the modX object
     * @param array $config An array of configuration options
     */
    function __construct(modX &$modx,array $config = array()) {
        $this->modx =& $modx;

        $corePath = $this->modx->getOption('core_path');
        $basePath = $this->modx->getOption('qrbuilder.core_path',$config,$this->modx->getOption('core_path').'components/qrbuilder/');
        $assetsUrl = $this->modx->getOption('qrbuilder.assets_url',$config,$this->modx->getOption('assets_url').'components/qrbuilder/');
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
            // from: http://modx.com/extras/package/ludwigqrcode and https://github.com/MoonMaker/modx/blob/master/QRCode/core/components/ludwigqrcode/
            'phpQrCodePath' => $corePath.'components/ludwigqrcode/model/phpqrcode/lib/',
            'jsUrl' => $assetsUrl.'js/',
            'cssUrl' => $assetsUrl.'css/',
            'assetsUrl' => $assetsUrl,
            'connectorUrl' => $assetsUrl.'connector.php',
            'qrCodeUrl' => $assetsUrl.$qrCodeDir
        ),$config);

        $this->modx->addPackage('qrbuilder',$this->config['modelPath']);
    }
    
    /**
     * @access public
     * @param (String) $url
     * @param (String) $file_name
     * @return (String) file path
     * 
     */
    public function buildQRCode($url, $file_name)
    {
        // qrCodePath
        if ( !file_exists($this->config['phpQrCodePath'].'full/qrlib.php') ) {
            return 'NOT FOUND: '.$this->config['phpQrCodePath'];
            return false;
        }
        
        require_once $this->config['phpQrCodePath'].'full/qrlib.php';
        
        // filename:
        
        $png_file = $this->config['qrCodePath'].$file_name.'.png';
        $svg_file = $this->config['qrCodePath'].$file_name.'.svg';
        
        $qr = new QRcode();
        /**
         * Creates PNG image containing QR-Code.
         * Simple helper function to create QR-Code Png image with one static call.
         * @param String $text text string to encode
         * @param String $outfile (optional) output file name, if __false__ outputs to browser with required headers
         * @param Integer $level (optional) error correction level __QR_ECLEVEL_L__, __QR_ECLEVEL_M__, __QR_ECLEVEL_Q__ or __QR_ECLEVEL_H__
         * @param Integer $size (optional) pixel size, multiplier for each 'virtual' pixel
         * @param Integer $margin (optional) code margin (silent zone) in 'virtual' pixels
         * @param Boolean $saveandprint (optional) if __true__ code is outputed to browser and saved to file, otherwise only saved to file. It is effective only if $outfile is specified.
        */
        $qr->png(
            $url,
            $png_file,
            QR_ECLEVEL_H,
            100 // @TODO have this as a system setting
        );
        
        //QRcode::png($url, $pngAbsoluteFilePath);
        if ( 1 == 1 ) {
            /**
             * Creates SVG with QR-Code.
             * Simple helper function to create QR-Code SVG with one static call.
             * @param String $text text string to encode
             * @param Boolean $elemId (optional) target SVG tag id attribute, if __false__ SVG tag with auto id will be created
             * @param String $outfile (optional) output file name, when __false__ file is not saved
             * @param Integer $level (optional) error correction level __QR_ECLEVEL_L__, __QR_ECLEVEL_M__, __QR_ECLEVEL_Q__ or __QR_ECLEVEL_H__
             * @param Integer $width (optional) SVG element width (sam as height)
             * @param Integer $size (optional) pixel size, multiplier for each 'virtual' pixel
             * @param Integer $margin (optional) code margin (silent zone) in 'virtual' pixels
             * @param Boolean $compress (optional) if __true__, compressed SVGZ (instead plaintext SVG) is saved to file
             * @return String containing SVG tag
             **/
            $output = $qr->svg( 
                $url,
                false, //$val['id'],
                $svg_file,
                QR_ECLEVEL_H,
                800,//$val['width'],
                100,//$val['size'],
                10, //$val['margin'],
                false//$val['compress'],
                //$val['back_color'],
                //$val['fore_color']
            );
        }
        return array(
                'png' => $this->config['qrCodeDir'].$file_name.'.png',
                'svg' => $this->config['qrCodeDir'].$file_name.'.svg',
            );
    }
    
    /**
     * Redirect
     * @param (String) $uri_search
     * @param (String) $context_key
     * @return VOID
     */
    public function redirect($uri_search, $context_key='web')
    {
        // search db:
        $qrcode = $this->modx->getObject('Qrcodes', 
            array( 
                'short_link' => $uri_search,
                'context_key' => $context_key,
                'active' => true,
            )
        );
        //echo 'Find Code';exit();
        if ( !empty($qrcode) && is_object($qrcode) ) {
            //echo 'Found ONE';
            // if valid build URL and send:
            $start = $this->getTime($qrcode->get('start_date'));
            
            $end = $this->getTime($qrcode->get('end_date'));
            
            $now = time();// @TODO system setting time offset
            $use_end = $qrcode->get('use_end_date');
            
            if ( $start > $now || ( $end < $now && $use_end ) ) {
                $qrcode->set('active', 0);
                // $qrcode->save();
                return;
            }
            // record stats:
            $qrcode->set('hits', $qrcode->get('hits')+1);
            $qrcode->save();
            
            // @TODO make this xpdo?
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
                //print_r($sth->errorInfo());
                $this->modx->log(modX::LOG_LEVEL_ERROR,'[QRBuilder] Error recording stat data: '.print_r($sth->errorInfo(), true) );
            }
            
            // build URL:
            $url = $qrcode->get('destination_url');
            if ( is_numeric($url) ) {
                // Assume MODX Resource
                // @TODO
            } else {
                //$params = $this->modx->fromJSON($qrcode->get('build_url_params'));
                $params = json_decode($qrcode->get('build_url_params'), true);
                foreach ($params as $key => $value) {
                    if ( empty($value) && $value !== 0 ) {
                        unset($params[$key]);
                    }
                }
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
            
            // now send:
            $options = array('responseCode' => 'HTTP/1.1 302 Found');
            
            $redirect_type = $qrcode->get('redirect_type');
            if ( $redirect_type == 301 ){
                $options = array('responseCode' => 'HTTP/1.1 301 Moved Permanently');
            }
            //echo 'URL: '.$url;exit();
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
        $time = time();
        if (version_compare(PHP_VERSION, '5.3.0') >= 0) {
            $tmpDate = DateTime::createFromFormat($format, $date );
            $time = $tmpDate->getTimestamp();
        } else {
            $time = strtotime( $date);
        }
        
        return $time;
    }
}