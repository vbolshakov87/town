<div class="aside-vote">
<?php $this->render('poll/results', array('model' => $model)); ?>

<?php if ($userVote->id): ?>
  <p id="pollvote-<?php echo $userVote->id ?>">
    <?=Yii::t('Poll', 'You voted')?>: <strong><?php echo $userChoice->label ?></strong>.<br />
    <?php
      if ($userCanCancel) {
        echo CHtml::ajaxLink(
          Yii::t('Poll', 'Cancel Vote'),
          array('/pollvote/delete', 'id' => $userVote->id, 'ajax' => TRUE),
          array(
            'type' => 'POST',
            'success' => 'js:function(){window.location.reload();}',
          ),
          array(
            'class' => 'cancel-vote',
            'confirm' => Yii::t('Poll', 'Are you sure you want to cancel your vote?')
          )
        );
      }
    ?>
  </p>
<?php else: ?>
  <p><?php echo CHtml::link('Vote', array('/poll/vote', 'id' => $model->id)); ?></p>
<?php endif; ?>
</div>