<div class="result">
  <div class="label">
    <?php echo CHtml::encode($choice->label); ?>
  </div>
  <div class="bar">
	  <div class="fill" style="width: <?php echo $percent; ?>%;"></div>
  </div>
  <div class="totals">
    <span class="percent"><?php echo $percent; ?>%</span>
    <span class="votes">(<?=(Yii::t('Poll', '{n} Vote|{n} Votes', $voteCount));?>)</span>
  </div>
</div>
