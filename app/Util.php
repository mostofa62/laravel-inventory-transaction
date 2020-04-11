<?php

namespace App;

/**
 * 
 */
class Util
{
	
	public function static operation_type($key=null)
	{
		$operation_type = [1=>'IN',2=>'OUT'];
		return isset($key)? $operation_type[$key]:$operation_type;
		
	}
}
