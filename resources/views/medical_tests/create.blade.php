<!-- Form for Create Modal -->
<form id="createForm">
    @csrf
    <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" class="form-control" id="name" name="name">
    </div>
    <div class="form-group">
        <label for="types">Types:</label>
        <input type="text" class="form-control" id="types" name="types">
    </div>
    <div class="form-group">
        <label for="description">Description:</label>
        <textarea class="form-control" id="description" name="description"></textarea>
    </div>
    <div class="form-group">
        <label for="price">Price:</label>
        <input type="text" class="form-control" id="price" name="price">
    </div>
    <!-- Add more fields as needed -->
    <button type="submit" class="btn btn-primary" id="saveBtn">Save</button>
</form>
