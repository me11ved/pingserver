<?php if ($this->result["status"] === false) : ?>

	<div  id="bad">
		<p>Ошибки:</p>
		<?php foreach ($this->result["response"]["errors"] as $error) : ?>
				<p><?=$error?> </p>
		<?php endforeach; ?>
	</div>
<?php elseif ($this->result["status"]) : ?>
	<div id="good">
		<b>Операция выполнена</b>
	</div>
	<?php if ($this->result["response"]["errors"]) : ?>	
		<div  id="warning">
			<?php foreach ($this->result["response"]["errors"] as $error) : ?>
					<p><?=$error?> </p>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
<?php endif; ?>

<div>
	<form action="/ping/addServersSave" method="POST">
		<div>
			<p>Группа серверов</p>
			<?php if ($this->groupsList) : ?>
			<label>
				Вы можете выбрать существующую группу или ввести новое имя группы при добавлении новых серверов
			</label>
				<select name="groupList">
					<option disabled selected="selected">Выберите группу</option>
					<?php foreach ($this->groupsList as $g) : ?>
						<option value="<?=$g["id"]?>">
							<?=$g["title"]?>
						</option>
					<?php endforeach; ?>
				</select>
			<?php endif; ?>
			<label>Новая группа</label>
			<input type="text" placeholder="Введите имя группы" value="<?=$this->data["newGroup"]?>" name="newGroup">
		</div>
		<div>
			<p>Список ip</p>
			<label>Формат ввода: <b>8.8.8.8;комментарий</b> каждый ip с новой строки</label>
			<textarea name="ips" id="" cols="30" rows="10"><?=$this->data["ips"]?></textarea>
		</div>
		<button>Добавить</button>
	</form>
</div>