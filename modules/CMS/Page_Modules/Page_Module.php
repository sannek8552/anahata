<?php
define('INITIAL_CHOICE','initial_choice');
/*
	Abstract class Paeg-Module 
	define base functions that must be present 
	in page module
*/
class Page_Module
{
	/*
		this function will be called by Strategy class
		
	*/
	function next_step($step)
	{
		//perform next step of menu creation/editing
		//$step is -1 to go previous step or 1 to go next step
	}
	
	function first_step()
	{
		//initialize menu creation
	}
	
	function params_to_back()
	{
		//should return params that should be posted back 
		//at pressing next step button
	}
	
	function final_step()
	{
		//perform final step of menu creation
		//should clear session for this module
		//display final message and post back any params that is useful in javascript front-end
	}
	
	function is_final()
	{
		//return true if current step was final
		//return false otherwise
	}
	
	function display()
	{
		//perform front end displaying of the page
	}
}
?>