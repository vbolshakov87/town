<?php
/**
 * Кдласс для работы с древовидными данными
 */
class TreeHandler
{
	/**
	 * Converts rowset to the forest
	 *
	 * @param   array   $rows            Two-dimensional array of resulting rows
	 * @param   string  $id_name         Name of ID field
	 * @param   string  $pid_name        Name of PARENT_ID field
	 * @param   string  $children_key    Key for nested array
	 * @param   bool    $is_unset_names  Unset ID and PARENT_ID fields
	 * @return  array                    Transformed array (tree)
	 */
	public static function rowsToTree(array $rows, $id_name, $pid_name, $children_key = 'child_nodes', $is_unset_names = false)
	{
		$children = array(); #children of each ID
		$ids = array();
		#Collect who are children of whom.
		foreach ($rows as $i => $r)
		{
			$row =& $rows[$i];
			$id = $row[$id_name];

			if ($id === null)
			{
				#Rows without an ID are totally invalid and makes the result tree to
				#be empty (because PARENT_ID = null means "a root of the tree"). So
				#skip them totally.
				continue;
			}
			$pid = $row[$pid_name];

			if ($id == $pid) $pid = null;



			//	$row['active'] = true;

			$children[$pid][$id] =& $row;

			if (! array_key_exists($id, $children)) $children[$id] = array();


			$row[$children_key] =& $children[$id];

			$ids[$id] = true;
		}

		#Root elements are elements with non-found PIDs
		$forest = array();
		foreach ($rows as $i => $r)
		{
			$row =& $rows[$i];
			$id  = $row[$id_name];
			$pid = $row[$pid_name];
			if ($pid == $id) $pid = null;
			if (! array_key_exists($pid, $ids)) $forest[$row[$id_name]] =& $row;
			if ($is_unset_names)
			{
				unset($row[$id_name]);
				unset($row[$pid_name]);
			}
		}

		return $forest;
	}
}