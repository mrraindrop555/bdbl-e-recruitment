<!DOCTYPE html>
<html lang="en">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('css/index.css') }}">

</head>

<body style="background-color: #f4f5f7;">
  <nav class="navbar" style="background-color:#00ab41">
    <div class="container-fluid px-4">
      <a class="navbar-brand d-flex">
        <img src="{{ asset('assets/Logo.png') }}" alt="Description" class="logo">
        <h5 class="d-none d-sm-block my-auto" style="color:white;">Bhutan Development Bank Limited</h5>
      </a>
      <div class="d-flex  mr-lg-5">
        <a href="/adminresult" class="btn" style="background-color:#fff;border:none;color:#00ab41;padding:7px 40px;border-radius:2px;">Logout</a>
      </div>
    </div>
  </nav>
  <div class="table-container">
    <h4>Job vacancy</h4>
    <div style="margin-bottom:20px">
      The Management of Bhutan Development Bank (BDB) would like to announce vacancy for the position indicated below in the table:
    </div>

    <div class="d-flex justify-content-between mb-4">
      <div>
        <a href="/adminresult" class="btn" style="background-color:#00ab41;border:none;color:white;padding:7px 40px;border-radius:2px;">View result</a>
      </div>
      <div>
        <a href="/adminresult" class="btn" data-bs-toggle="modal" data-bs-target="#exampleModal" style="background-color:#00ab41;border:none;color:white;padding:7px 40px;border-radius:2px;">Add vacancy</a>
      </div>
    </div>


    <table class="table table-bordered" style="color: #212122;">
      <thead>
        <tr class="text-center">
          <th scope="col">Sl/no</th>
          <th scope="col">Position Title</th>
          <th scope="col">Slot</th>
          <th scope="col">Employment Type & Grade</th>
          <th>Attachments</th>
          <th></th>

        </tr>
      </thead>
      <tbody>
        <tr>
          <td scope="row">1</td>
          <td> General Manager ICT & Digital Banking Division</td>
          <td class="text-center">1</td>
          <td>
            <ul>
              <li>Contract basis</li>
              <li>3 years (Extendable based on the performance and requirement)</li>
            </ul>
          </td>
          <td>
            <a href="" style="color:#00ab41">Download TOR</a>
          </td>
          <td>
            <a href="/adminDetail" style="text-decoration: none;color:#00ab41">More Details</a>
          </td>
        </tr>

        <tr>
          <td scope="row">1</td>
          <td> Software Developer</td>
          <td class="text-center">1</td>
          <td>
            <ul>
              <li>Contract basis</li>
              <li>3 years (Extendable based on the performance and requirement)</li>
            </ul>
          </td>


          <td>
            <a href="" style="color:#00ab41">Download TOR</a>
          </td>
          <td>
            <a href="/adminDetail" style="text-decoration: none;color:#00ab41">More Details</a>
          </td>
        </tr>


      </tbody>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form class="row g-3">
              <div class="col-md-6">
                <label for="inputEmail4" class="form-label">Position Title</label>
                <input type="email" class="form-control" id="inputEmail4">
              </div>
              <div class="col-md-6">
                <label for="inputPassword4" class="form-label">Number of slots</label>
                <input type="password" class="form-control" id="inputPassword4">
              </div>
              <div class="col-12">
                <label for="inputAddress" class="form-label">Employment Type & Grade</label>
                <input type="text" class="form-control" id="inputAddress">
              </div>
              <div class="col-12">
                <label for="inputAddress2" class="form-label">Qualification & Criteria</label>
                <input type="text" class="form-control" id="inputAddress2">
              </div>
              <div class="col-md-12">
                <label for="inputCity" class="form-label">Gross Salary & other benefits</label>
                <input type="text" class="form-control" id="inputCity">
              </div>
              <div class="my-4">
                <input class="form-control" type="file" id="formFile">
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <a href="/adminresult" class="btn" data-bs-toggle="modal" data-bs-target="#exampleModal" style="background-color:red;border:none;color:white;padding:7px 40px;border-radius:2px;">close</a>
            <a href="/adminresult" class="btn" data-bs-toggle="modal" data-bs-target="#exampleModal" style="background-color:#00ab41;border:none;color:white;padding:7px 40px;border-radius:2px;">Save</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-12">
  <label for="employmentTypeGrade" class="form-label">Employment Type & Grade</label>
  <div class="input-group mb-3">
    <input type="text" class="form-control" id="employmentTypeGrade" placeholder="Enter employment type & grade">
    <button class="btn btn-primary" type="button" id="addEmploymentTypeGrade" style="background-color:#00ab41; border:none;">Add</button>
  </div>
  <ul class="list-group" id="employmentTypeGradeList"></ul>
</div>

<script>
  document.getElementById('addEmploymentTypeGrade').addEventListener('click', function() {
    const input = document.getElementById('employmentTypeGrade');
    const inputValue = input.value.trim();
    if (inputValue !== '') {
      const ul = document.getElementById('employmentTypeGradeList');
      const li = document.createElement('li');
      li.className = 'list-group-item';
      li.textContent = inputValue;
      ul.appendChild(li);
      input.value = '';
    }
  });
</script>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</html>