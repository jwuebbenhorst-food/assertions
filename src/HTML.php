<?php

namespace Dxw\Assertions;

trait HTML
{
    private function _assertHTMLEquals($expected, $actual, $ignoreWhitespace = false)
    {
        $input = [$expected, $actual];
        $output = [];

        foreach ($input as $val) {
            $html5 = new \Masterminds\HTML5();
            $dom = $html5->loadHTMLFragment('<div>'.$val.'</div>');
            $out = $html5->saveHTML($dom);
            if ($ignoreWhitespace) {
                $out = preg_replace('/>\s+/m', '>', $out);
                $out = preg_replace('/\s+</m', '<', $out);
            }
            $out = preg_replace('_^<div>_', '', $out);
            $out = preg_replace('_</div>$_', '', $out);
            $output[] = $out;
        }

        $this->assertEquals($output[0], $output[1]);
    }

    public function assertHTMLEqualsStrictWhitespace($expected, $actual)
    {
        return $this->_assertHTMLEquals($expected, $actual, false);
    }

    public function assertHTMLEquals($expected, $actual)
    {
        return $this->_assertHTMLEquals($expected, $actual, true);
    }
}
