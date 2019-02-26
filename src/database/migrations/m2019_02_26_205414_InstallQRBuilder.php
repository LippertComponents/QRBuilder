<?php

/**
 * Auto Generated from Blender
 * Date: 2019/02/26 at 20:54:14 UTC +00:00
 */

use \LCI\Blend\Migrations;

class m2019_02_26_205414_InstallQRBuilder extends Migrations
{
    protected $qrbuilder_xpdo_classes = [
        'Qrcodes',
        'QrcodeStats'
    ];

    protected $plugins = [
        'QRBuilder' => [
            'description' => 'QRBuilder, fires on 404',
            'events' => [
                'onPageNotFound'
            ]
        ]
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $qrBuilder = new \LCI\MODX\QRBuilder\QRBuilder($this->modx);

        // Create tables:
        $xPDOManager = $this->modx->getManager();

        foreach ($this->qrbuilder_xpdo_classes as $class_name) {
            if ($xPDOManager->createObjectContainer($class_name)) {
                $this->blender->outSuccess('Created the xPDO class table: '.$class_name);
            }
        }

        foreach ($this->plugins as $plugin_name => $data) {
            /** @var \LCI\Blend\Blendable\Plugin $blendablePlugin */
            $blendablePlugin = $this->blender->getBlendableLoader()->getBlendablePlugin($plugin_name);

            $blendablePlugin
                ->setSeedsDir($this->getSeedsDir())
                ->setFieldDescription($data['description'])
                ->setAsStatic('lci/modx-qrbuilder/src/elements/plugins/'.$plugin_name.'.php', 'orchestrator')
                ->setFieldCategory('LCI=>QRBuilder');

            foreach ($data['events'] as $event) {
                $blendablePlugin->attachOnEvent($event);
            }

            if ($blendablePlugin->blend(true)) {
                $this->blender->out($plugin_name.' plugin was created successfully!');
            } else {
                $this->blender->outError($plugin_name.' plugin was not created successfully!');
            }
        }

        // MODX namespace
        $qrbuilderNameSpace = $this->modx->getObject('modNamespace', 'qrbuilder');
        if (!$qrbuilderNameSpace) {
            /** @var \modNamespace $qrbuilderNameSpace */
            $qrbuilderNameSpace = $this->modx->newObject('modNamespace');
            $qrbuilderNameSpace->set('name', 'qrbuilder');
            $qrbuilderNameSpace->set('path', '{core_path}vendor/lci/modx-qrbuilder/src/');
            $qrbuilderNameSpace->set('assets_path', '{assets_path}components/qrbuilder/');
            if ($qrbuilderNameSpace->save()) {
                $this->blender->outSuccess('The modNamespace qrbuilder has been created');
            } else {
                $this->blender->out('The modNamespace qrbuilder was not created', true);
            }
        }

        // Manager parts
        // menu
        $modMenu = $this->modx->getObject('modMenu', ['text' => 'qrbuilder']);

        if (!$modMenu) {
            $modMenu = $this->modx->newObject('modMenu');

            $modMenu->set('menuindex', 2);
            $modMenu->set('text', 'qrbuilder');
            $modMenu->set('description', 'qrbuilder.desc');
            $modMenu->set('parent', 'components');
            //$modMenu->set('permissions', '');
            $modMenu->set('namespace', 'qrbuilder');
            /**
             * @see: https://github.com/BobRay/MyComponent/blob/master/_build/data/transport.menu.php
             * @see: https://docs.modx.com/revolution/2.x/developing-in-modx/advanced-development/custom-manager-pages/custom-manager-pages-in-2.3
             * @see: https://docs.modx.com/revolution/2.x/developing-in-modx/advanced-development/custom-manager-pages/custom-manager-pages-tutorial
             *
             * As of MODX 2.3 like this:
             *
             * Note: will route to the first found of the following:
             * [namespace-path]controllers/[manager-theme]/index.class.php
             * [namespace-path]controllers/default/index.class.php
             * [namespace-path]controllers/index.class.php
             */
            $modMenu->set('action', 'index');

            $saved = false;
            try {
                $saved = $modMenu->save();

            } catch (Exception $exception) {
                $error_message = $exception->getMessage();
            }

            if ($saved) {
                $this->blender->outSuccess('The modMenu qrbuilder has been created');
            } else {
                $this->blender->out('The modMenu qrbuilder was not created: '.$error_message, true);
                exit();
            }
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $qrbuilder = new \LCI\MODX\QRBuilder\QRBuilder($this->modx);

        $xPDOManager = $this->modx->getManager();

        foreach ($this->qrbuilder_xpdo_classes as $class_name) {
            if ($xPDOManager->removeObjectContainer($class_name)) {
                $this->blender->outSuccess('Created the xPDO class table: '.$class_name);
            }
        }

        // snippets
        foreach ($this->plugins as $plugin_name => $data) {
            /** @var \LCI\Blend\Blendable\Plugin $blendablePlugin */
            $blendablePlugin = $this->blender->getBlendableLoader()->getBlendablePlugin($plugin_name);

            $blendablePlugin->setSeedsDir($this->getSeedsDir());

            if ($blendablePlugin->delete()) {
                $this->blender->out($plugin_name.' plugin was deleted successfully!');
            } else {
                $this->blender->outError($plugin_name.' plugin was not deleted successfully!');
            }
        }

        // MODX namespace
        $qrbuilderNameSpace = $this->modx->getObject('modNamespace', 'qrbuilder');
        if ($qrbuilderNameSpace) {
            if ($qrbuilderNameSpace->remove()) {
                $this->blender->outSuccess('The modNamespace qrbuilder has been removed');
            } else {
                $this->blender->out('The modNamespace qrbuilder was not removed', true);
            }
        }

        $modMenu = $this->modx->getObject('modMenu', ['text' => 'qrbuilder']);

        if ($modMenu) {

            if ($modMenu->remove()) {
                $this->blender->outSuccess('The modMenu qrbuilder has been removed');
            } else {
                $this->blender->out('The modMenu qrbuilder was not removed', true);
            }
        }
    }

    /**
     * Method is called on construct, please fill me in
     */
    protected function assignDescription()
    {
        $this->description = 'Install QR Builder';
    }

    /**
     * Method is called on construct, please fill me in
     */
    protected function assignVersion()
    {

    }

    /**
     * Method is called on construct, can change to only run this migration for those types
     */
    protected function assignType()
    {
        $this->type = 'master';
    }

    /**
     * Method is called on construct, Child class can override and implement this
     */
    protected function assignSeedsDir()
    {
        $this->seeds_dir = 'm2019_02_26_205414_InstallQRBuilder';
    }
}