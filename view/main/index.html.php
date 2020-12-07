<form name="getNumber" class="row justify-content-center form-content align-items-center">
	<div class="form-group col-4">
		<input type="text" class="form-control" name="text" id="text" autocomplete="off" placeholder="Ваше число">
	</div>
	<div class="form-group col-4">
		<button type="submit" class="btn btn-primary col-12">розрахувати</button>
	</div>
	<div class="justify-content-center row col-12 result-block d-none">
		<div class="alert alert-success col-8">
			<p><strong>Результат:</strong> <span id="result"></span></p>
			<p><strong>Запит виконано:</strong> <span id="time"></span></p>
		</div>
	</div>
</form>