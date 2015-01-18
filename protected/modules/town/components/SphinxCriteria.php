<?php
/**
 * Criteria ��� ������ �� sphinx
 */
class SphinxCriteria
{

	const SPHINX_CRITERIA_ANY = 'any';
	const SPHINX_CRITERIA_ALL = 'all';

	public $index; // � ����� ������� ������
	public $match = self::SPHINX_CRITERIA_ANY; // ��� ���������� (�� ���������� || �� ���������)
	public $select;
	public $text; // ��������� ������
	public $limit = 20;
	public $offset = 0;
	public $filters = array();
	public $order;
	public $condition;
	public $distinct = false;
	public $params;
	public $weight = array ( 100, 20, 1 );


	public function __construct(array $criteriaParams = array())
	{
		foreach ($criteriaParams as $param => $value) {
			$this->{$param} = $value;
		}
	}


	public function addCondition($condition)
	{
		$this->condition .= $condition;
	}


	public function getCondition()
	{

	}
}