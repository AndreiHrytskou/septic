<?php
if($c){return;}$dir = dirname(dirname(dirname(dirname(__DIR__))))."/".$admin."/model/";$file = $dir . $model . ".php";

	

$class = "Model" . preg_replace("/[^a-zA-Z0-9]/", "", $model);

if (file_exists($file)) {
                include_once($file);
                
                $this->registry->set("ocext_model_" . str_replace("/", "_", $model), new $class($this->registry));

                //return TRUE;

} else {
                trigger_error("Error: Could not load model " . $file . "!");
                exit();} 