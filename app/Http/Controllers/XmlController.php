<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class XmlController extends Controller
{
    public function transform()
    {
        $xml = new \DOMDocument();
        $xml->load(resource_path('xml/purchaseditems.xml'));

        $xsl = new \DOMDocument();
        $xsl->load(resource_path('xsl/style.xsl'));

        $proc = new \XSLTProcessor();
        $proc->importStylesheet($xsl);

        $html = $proc->transformToXML($xml);

        return view('payHistory', ['html' => $html]);
    }
}
