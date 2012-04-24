<?php
interface Listable
{
	//should return sql list will use to get results from database
	public function get_list_sql();

	//should return heading columns array that list will use as header and or custom formatters if any
	public function get_column_defs();

	//should return list of columns returned by list sql
	public function get_source_fields();

	public function prepare_filters($filters);
}
?>