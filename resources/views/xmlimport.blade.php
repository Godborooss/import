<form method="post" action="{{ route('xmlimport.import') }}" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="xmlFile">Выберите файл XML:</label>
        <input type="file" name="xmlFile" id="xmlFile" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Импортировать</button>
</form>
