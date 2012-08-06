<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 15.07.12
 * Time: 13:07
 * To change this template use File | Settings | File Templates.
 */

class Xblog_SimpleXml_Element extends SimpleXMLElement
{

    public function extend(Xblog_SimpleXml_Element $xmlDocument) {
        foreach($xmlDocument->children() as $child) {
            $this->appendChild($child);
        }
    }
    public function appendChild(Xblog_SimpleXml_Element $childIncoming) {
        $incomingName = $childIncoming->getName();
        $currentChild = null;

        $childrenCurrentDocument = $this->{$incomingName};
        if(!$childrenCurrentDocument) {
            $currentChild = $this->addChild($incomingName);
        } else {
            foreach ($childrenCurrentDocument as $child) {
                if ( $child->getName() == $incomingName
                    && $child->attributes()->name == $childIncoming->attributes()->name
                ) {
                    $currentChild = $child;
                }
            }
        }

        if ($currentChild === null) {
            $currentChild = $this->addChild($incomingName);
        }

        foreach($childIncoming->attributes() as $attributeName => $attributeValue) {
            $currentChild->addAttribute($attributeName, $attributeValue);
        }

        if ($childIncoming->count()) {
            foreach ($childIncoming->children() as $incomingChildElement) {
                $currentChild->appendChild($incomingChildElement);
            }
        }
        return $this;
    }

    public function getAttributes() {
        $attributes = array();
        foreach( $this->attributes() as $name => $value) {
            $attributes[$name] = (string) $value;
        }

        return $attributes;
    }

    public function count() {
        return count($this->children());
    }
}
