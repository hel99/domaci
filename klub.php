<?php
if (!isset($_GET['id'])) {
  header('Location: index.php');
  exit;
}

include 'header.php';
?>
<div class="container p-3 bg-white rounded">
  <h1 class="text-center">Izmeni klub</h1>
  <div class="row">
    <div class="col-4">
      <form id='forma'>
        <div class="form-group">
          <label for="id" class="col-form-label">ID</label>
          <input disabled value="<?php echo $_GET['id']; ?>" required class="form-control" id="id">
        </div>
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
    <div class="col-5">
      <h2>Zanrovi pesama u klubu</h2>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Naziv</th>
            <th>Obrisi</th>
          </tr>
        </thead>
        <tbody id="zanrovi">

        </tbody>
      </table>
    </div>
    <div class="col-3">
      <h2>Dodaj zanr</h2>
      <form id='formaZanr'>
        <div class="form-group">
          <label for="zanr" class="col-form-label">Zanr</label>
          <select class="form-control" id="zanr"></select>
        </div>
        <button type="submit" class="btn btn-primary form-control">Dodaj</button>
      </form>
    </div>
  </div>
</div>
<script>
  let zanrovi = [];
  let klub = undefined;
  $(document).ready(() => {
    ucitajKlub();
    ucitajZanrove();
    $("#formaZanr").submit(e => {
      e.preventDefault();
      const zanr = $('#zanr').val();
      $.post('server/klub-api/dodaj-zanr.php', {
        zanr,
        klub: $('#id').val()
      }).then(res => {
        res = JSON.parse(res);
        if (!res.success) {
          alert(res.greska);
        }
        ucitajKlub();
      })
    })
    $('#forma').submit(e => {
      e.preventDefault();
      $.post('server/klub-api/izmeni.php', {
        naziv: $('#naziv').val(),
        id: $('#id').val(),
        adresa: $('#adresa').val(),
        radno_vreme: $('#radnoVreme').val(),
        rating: $('#rating').val(),
      }).then(res => {
        res = JSON.parse(res);
        if (!res.success) {
          alert(res.greska);
        }
        ucitajKlub();
      })
    })
  })

  function ucitajZanrove() {
    $.getJSON('server/zanr-api/vratiSve.php').then(res => {
      if (!res.success) {
        alert(res.greska);
        return;
      }
      zanrovi = res.zanrovi;
      popuniListuZanrova();
    })
  }

  function popuniListuZanrova() {
    if (!klub) {
      return;
    }
    $('#zanr').html('');
    $('#zanrovi').html('');
    for (let zanr of zanrovi) {
      if (klub.zanrovi.find(e => e.id == zanr.id) !== undefined) {
        $("#zanrovi").append(`
          <tr>
            <td>${zanr.naziv}</td>
            <td>
              <button onClick="izbaciZanr(${zanr.id})" class='btn btn-danger'>Obrisi</button>
            </td>
          </tr>
        `)
      } else {
        $("#zanr").append(`
          <option value="${zanr.id}">${zanr.naziv}</option>
        `)
      }
    }
  }

  function ucitajKlub() {
    $.getJSON('server/klub-api/vratiJedan.php?id=' + $('#id').val()).then(res => {
      if (!res.success) {
        alert(res.greska);
        return;
      }
      klub = res.klub;
      $('#naziv').val(res.klub.naziv);
      $('#adresa').val(res.klub.adresa);
      $('#rating').val(res.klub.rating);
      $('#radnoVreme').val(res.klub.radno_vreme);
      popuniListuZanrova();
    })
  }

  function izbaciZanr(zanr) {
    $.post('server/klub-api/izbaci-zanr.php', {
      zanr,
      klub: $('#id').val()
    }).then(res => {
      res = JSON.parse(res);
      if (!res.success) {
        alert(res.greska);
      }
      ucitajKlub();
    })
  }
</script>
</body>