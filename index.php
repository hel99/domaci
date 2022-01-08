<?php
include 'header.php';
?>
<div class="container p-3 bg-white rounded">
  <h1>Klubovi</h1>
  <div class="row">
    <div class="col-8">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>ID</th>
            <th>Naziv</th>
            <th>Adresa</th>
            <th>Radno vreme</th>
            <th>Ocena</th>
            <th>Izmeni</th>
            <th>Obrisi</th>
          </tr>
        </thead>
        <tbody id='klubovi'>

        </tbody>
      </table>
    </div>
    <div class="col-4">
      <h2>Kreiraj klub</h2>
      <form id='forma'>
        <div class="form-group">
          <label for="naziv" class="col-form-label">Naziv</label>
          <input required class="form-control" id="naziv">
        </div>
        <div class="form-group">
          <label for="adresa" class="col-form-label">Adresa</label>
          <input required class="form-control" id="adresa">
        </div>
        <div class="form-group">
          <label for="radnoVreme" class="col-form-label">Radno vreme</label>
          <input required class="form-control" id="radnoVreme">
        </div>
        <div class="form-group">
          <label for="rating" class="col-form-label">Ocena</label>
          <input required type="number" min="1" max="5" class="form-control" id="rating">
        </div>
        <button type="submit" class="btn btn-primary form-control">Sacuvaj</button>
      </form>
    </div>
  </div>
</div>
<script>

  $(document).ready(() => {
    ucitajKlubove();
    $('#forma').submit(e => {
      e.preventDefault();
      $.post('server/klub-api/kreiraj.php', {
        naziv: $('#naziv').val(),
        adresa: $('#adresa').val(),
        radno_vreme: $('#radnoVreme').val(),
        rating: $('#rating').val(),
      }).then(res => {
        res = JSON.parse(res);
        if (!res.success) {
          alert(res.greska);
        }
        ucitajKlubove();
      })
    })
  })

  function ucitajKlubove() {
    $.getJSON('server/klub-api/vratiSve.php').then(res => {
      if (!res.success) {
        alert(res.greska);
        return;
      }
      $('#klubovi').html('');
      for (let klub of res.klubovi) {
        $("#klubovi").append(`
            <tr>
              <td>${klub.id}</td>
              <td>${klub.naziv}</td>
              <td>${klub.adresa}</td>
              <td>${klub.radno_vreme}</td>
              <td>${klub.rating}</td>
              <td>
                <a href='klub.php?id=${klub.id}'>
                  <button class='btn btn-success'>Izmeni</button>  
                </a>
              </td>
              <td>
                <button onClick="obrisi(${klub.id})" class='btn btn-danger'>Obrisi</button>  
              </td>  
            </tr>
          `)
      }
    })
  }
  function obrisi(id) {
    $.post('server/klub-api/obrisi.php', { id }).then(res => {
      res = JSON.parse(res);
      if (!res.success) {
        alert(res.greska);
      }
      ucitajKlubove();
    })
  }
</script>
</body>