<?php

function loadLibraries(){
        spl_autoload_register(function ($class) {
            $files =  array("TConnection","TCriteria","TExpression","TFilter",
                            "TSqlDelete","TSqlInsert","TSqlInstruction","TSqlSelect","TSqlUpdate");
            if(in_array($class,$files))
                include "application/libraries/" . $class . ".php";
        }); 
}