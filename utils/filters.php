<?php

class Filters
{
	mysql_query_filter(&$query)
	{
		return mysql_real_escape_string($query);
	}
}

?>