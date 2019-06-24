<?php
function xml2assoc($xml) {
    $tree = null;
    while($xml->read())
        switch ($xml->nodeType) {
            case XMLReader::END_ELEMENT: return $tree;
            case XMLReader::ELEMENT:
                $node = array('tag' => $xml->name, 'value' => $xml->isEmptyElement ? '' : xml2assoc($xml));
                if($xml->hasAttributes)
                while($xml->moveToNextAttribute())
                    $node['attributes'][$xml->name] = $xml->value;
		           if ($node['tag'] == 'sign'){
		           $sign = $node['value'];
		           	continue;
		           }
                $tree[] = $node;
                break;
            case XMLReader::TEXT:
            case XMLReader::CDATA:
                $tree .= $xml->value;
    }
    return $tree;
}


?>