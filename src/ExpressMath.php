<?php

namespace ExpressMath;

use \MathParser\StdMathParser;
use \MathParser\Interpreting\Evaluator;

class ExpressMath {
    public $initRegex = "@\{\{((?:.|\n)+?)\}\}@";
    public $evalRegex = "@\{%((?:.|\n)+?)%\}@";

    private $parser;
    private $evaluator;

    private $variables = [];
    private $value;
    private $string;

    public function __construct() {
        $this->parser = new StdMathParser;
        $this->evaluator = new Evaluator;
    }

    public function eval($mathlang, array $options = []) {
        preg_match_all($this->initRegex, $mathlang, $matches);
        $variables = array_map(function($value) {
            return trim($value);
        }, array_values($matches[1]));
        $set = [];

        $default = mt_rand(1, 100);

        foreach ($variables as $key) {
            if(isset($options[$key])) {
                $copy = $options[$key];
                $set[$key] = $copy;
            }
            else {
                $set[$key] = $default;
            }
        }

        preg_match($this->evalRegex, $mathlang, $eval);
        $AST = $this->parser->parse($eval[1]);

        $this->evaluator->setVariables($set);
        $value = $AST->accept($this->evaluator);

        $this->string = $mathlang;
        $this->variables = $set;
        $this->value = $value;
        return $this;
    }

    public function getValue() {
        return $this->value;
    }

    public function getProblem() {
        $problem = preg_replace($this->evalRegex, '', $this->string);
        $problem = preg_replace_callback($this->initRegex, function($matches) {
            return $this->variables[trim($matches[1])];
        }, $problem);

        return $problem;
    }

    public function getVariables() {
        return $this->variables;
    }


}