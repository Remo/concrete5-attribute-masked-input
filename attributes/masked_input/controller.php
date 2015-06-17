<?php

namespace Concrete\Package\AttributeMaskedInput\Attribute\MaskedInput;

use Loader,
    \Concrete\Core\Foundation\Object,
    \Concrete\Core\Attribute\Controller as AttributeTypeController,
    \Concrete\Core\Attribute\DefaultController as DefaultAttributeTypeController;

class Controller extends DefaultAttributeTypeController
{

    protected $searchIndexFieldDefinition = array('type' => 'text', 'options' => array('notnull' => false));

    public function type_form()
    {
        $this->set('form', Loader::helper('form'));
        $this->load();
    }

    public function load()
    {
        $ak = $this->getAttributeKey();
        $db = Loader::db();

        if (is_object($ak)) {
            $row = $db->GetRow('SELECT mask FROM atMaskedInput WHERE akID = ?', array($ak->getAttributeKeyID()));
            foreach ($row as $item => $value) {
                $this->set($item, $value);
            }
        }
    }

    public function saveKey($data)
    {
        $ak = $this->getAttributeKey();
        $db = Loader::db();

        $db->Replace('atMaskedInput', [
            'akID' => $ak->getAttributeKeyID(),
            'mask' => $data['mask'],
        ], ['akID'], true);
    }

    public function form()
    {
        if (is_object($this->attributeValue)) {
            $value = Loader::helper('text')->entities($this->getAttributeValue()->getValue());
        }
        print Loader::helper('form')->text($this->field('value'), $value);

        $this->load();

        $jQuerySelector = '#' . str_replace(['[', ']'], ['\\\\[', '\\\\]'], $this->field('value'));
        $this->addFooterItem(Loader::helper('html')->javascript('jquery.maskedinput.js', 'attribute_masked_input'));
        $this->addFooterItem('<script type="text/javascript">
            $("' . $jQuerySelector . '").mask("' . $this->get('mask') . '");
            </script>');
    }

    public function exportKey($akey)
    {
        $this->load();
        $akey->addChild('mask')->addAttribute('value', $this->get('mask'));
        return $akey;
    }

    public function importKey($akey)
    {
        if (isset($akey->mask)) {
            $data['mask'] = $akey->mask['value'];
            $this->saveKey($data);
        }
    }

    public function composer()
    {
        if (is_object($this->attributeValue)) {
            $value = Loader::helper('text')->entities($this->getAttributeValue()->getValue());
        }
        print Loader::helper('form')->text($this->field('value'), $value, array('class' => 'span5'));
    }

}