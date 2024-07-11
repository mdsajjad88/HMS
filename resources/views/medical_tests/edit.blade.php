<!-- Form for Edit Modal -->
<form id="editForm{{$medicalTest->id}}">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" class="form-control" id="name" name="name" value="{{$medicalTest->name}}">
    </div>
    <div class="form-group">
        <label for="types">Types:</label>
        <input type="text" class="form-control" id="types" name="types" value="{{$medicalTest->types}}">
    </div>
    <div class="form-group">
        <label for="description">Description:</label>
        <textarea class="form-control" id="description" name="description">{{$medicalTest->description}}</textarea>
    </div>
    <div class="form-group">
        <label for="price">Price:</label>
        <input type="text" class="form-control" id="price" name="price" value="{{$medicalTest->price}}">
    </div>
    <!-- Add more fields as needed -->
    <button type="submit" class="btn btn-primary" id="updateBtn{{$medicalTest->id}}">Update</button>
</form>
