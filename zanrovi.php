<?php
include 'header.php';
?>
<div class="container p-3 bg-white rounded">
  <h1 class="text-center">Zanrovi</h1>
  <div class="row">
    <div class="col-7">
      <div>
        <input type="text" placeholder="Pretrazite zanrove" id='pretraga' class="form-control">
      </div>
      <table class="table table-striped mt-2">
        <thead>
          <tr>
            <th>ID</th>
            <th>Naziv</th>
            <th>Izmeni</th>
            <th>Obrisi</th>
          </tr>
        </thead>
        <tbody id='zanrovi'>

        </tbody>
      </table>
    </div>
    <div class="col-5">
      <h2 id='formaNaslov' class="text-center">Dodaj zanr</h2>
      <form id='forma'>
        <div class="form-group">
          <label for="naziv" class="col-form-label">Naziv</label>
          <input required class="form-control" id="naziv">
        </div>
        <button type="submit" class="btn btn-primary form-control">Sacuvaj</button>
      </form>
      <button hidden id='nazad' class="btn btn-secondary mt-3 form-control">Nazad</button>
    </div>
  </div>
</div>
<script>
  let zanrovi = [];
  let selIndex = -1;
  $(document).ready(() => {
    ucitajZanrove();
    $('#pretraga').change(iscrtaj);
    $('#forma').submit(e => {
      e.preventDefault();
      let telo = {
        naziv: $('#naziv').val()
      }
      let putanja = selIndex === -1 ? 'server/zanr-api/kreiraj.php' : 'server/zanr-api/izmeni.php';
      if (selIndex > -1) {
        telo.id = zanrovi[selIndex].id;
      }
      $.post(putanja, telo).then(res => {
        res = JSON.parse(res);
        if (!res.success) {
          alert(res.greska);
        }
        setujFormu(-1);
        ucitajZanrove();
      })
    })
  })
  $('#nazad').click(() => {
    setujFormu(-1);

  })

  function ucitajZanrove() {
    $.getJSON('server/zanr-api/vratiSve.php').then(res => {
      if (!res.success) {
        alert(res.greska)
        return;
      }
      zanrovi = res.zanrovi;
      iscrtaj();
    })
  }

  function iscrtaj() {
    const pretraga = $('#pretraga').val();
    const validni = zanrovi.filter(element => {
      return element.naziv.toLocaleLowerCase().startsWith(pretraga.toLocaleLowerCase());
    })
    $('#zanrovi').html('');
    let ind = 0;
    for (let element of validni) {
      $('#zanrovi').append(`
        <tr>
            <td>${element.id}</td>
            <td>${element.naziv}</td>
            <td>
              <button onClick="setujFormu(${ind})" class='btn btn-success'>Izmeni</button>
            </td>
            <td>
              <button onClick="obrisiZanr(${element.id})" class='btn btn-danger'>Obrisi</button>
            </td>
        </tr>
      `)
      ind++;
    }
  }

  function obrisiZanr(id) {
    $.post('server/zanr-api/obrisi.php', {
      id
    }).then(res => {
      res = JSON.parse(res);
      if (!res.success) {
        alert(res.greska);
        return;
      }
      zanrovi = zanrovi.filter(e => e.id != id);
      iscrtaj();
      setujFormu(-1);
    })
  }

  function setujFormu(ind) {
    selIndex = Number(ind);
    if (isNaN(selIndex)) {
      return;
    }
    if (selIndex === -1) {
      $('#naziv').val('');
      $('#formaNaslov').html('Kreiraj zanr');
      $('#nazad').attr('hidden', true);
    } else {
      $('#naziv').val(zanrovi[selIndex].naziv);
      $('#formaNaslov').html('Izmeni zanr');
      $('#nazad').attr('hidden', false);
    }
  }
</script>

</body>