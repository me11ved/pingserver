<?php if ($this->result["status"]) : ?>
<div>
	<p>Результат:</p>
	<form action="/ping/pingServersSave" method="POST">
	<div id="code">
		<textarea name="result"  readonly>
			<?=$this->result["response"]["result"] ?>
		</textarea>
		<input name="id"  readonly hidden value="<?=$this->result["response"]["id"] ?>">
	</div>
	<button>Сохранить</button>
	</form>
</div>

<?php else : ?>

<div>
	<?php if ($this->data) : ?>
	<form action="/ping/pingServersStart" method="POST">
		<div>
			<p>Список серверов</p>
			<label>
				Выберите из списка нужный сервер и нажмите Отправить
			</label>
				<select name="server">
					<option disabled selected="selected">Выберите сервер</option>
					<?php foreach ($this->data as $s) : ?>
						<option value="<?=$s["ip"]?>">
							<?=$s["ip"]?> (<?=$s["title"]?>)
						</option>
					<?php endforeach; ?>
				</select>
		</div>
	<button>Отправить</button>
	</form>
	<?php else : ?>
		<h3 id="warning">
			Серверов для пинга пока нет, <a href="/ping/addServers">добавить ip?</a>
		</h3>
<?php endif; ?>
</div>

<?php endif; ?>