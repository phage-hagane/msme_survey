<?php
$page = "SUCCESS FACTORS";
$protected = false;
require_once("assets/components/templates/header.php");
require_once("assets/components/templates/topbar.php");
require_once("assets/components/templates/sidebar.php");
?>

<main id="main" class="main">

  <div class="pagetitle">
    <h1>
      <?= $page ?> <button class="btn btn-outline-secondary float-end" data-bs-toggle="modal" data-bs-target="#success-factor-info"><i class="bi bi-info-square"></i></button>
    </h1>
    <span>
      <em>
        <strong>Direction:</strong> Kindly assess your level of success factor as deemed applicable. (Continue to other
        main indicator from
        Very Low to Very High)
      </em>
    </span>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <form id="sfa-form">
          <input type="hidden" name="ref" id="ref" value="<?= $_GET['ref'] ?>" />
          <?php
          $query = $conn->query("SELECT * FROM sfms");
          while ($row = $query->fetch_object()) {
          ?>
            <div class="accordion mb-3" id="accordion<?= $row->sfm_code ?>">
              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $row->sfm_code ?>" aria-expanded="true" aria-controls="collapse<?= $row->sfm_code ?>">
                    <p data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="<?= $row->sfm_desc ?>">
                      <?= $row->sfm ?>
                    </p>
                  </button>
                </h2>
                <div id="collapse<?= $row->sfm_code ?>" class="accordion-collapse collapse show" data-bs-parent="#accordion<?= $row->sfm_code ?>">
                  <div class="accordion-body">
                    <div class="row mt-3">
                      <div class="col-lg-6 col-md-12 col-sm-12 small text-center text-muted d-none d-lg-flex">
                        <p><strong>Criteria</strong></p>
                      </div>
                      <div class="col-lg-2 col-md-12 col-sm-12 small text-muted d-none d-lg-flex row">
                        <p><strong>Selection</strong></p>
                      </div>
                    </div>
                    <?php
                    $query2 = $conn->query("SELECT * FROM sfsms WHERE sfm_id = $row->id");
                    while ($row2 = $query2->fetch_object()) {
                    ?>
                      <div class="row mt-3">
                        <div class="col-lg-6 col-md-12 col-sm-12 small">
                          <p data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="<?= $row2->sfsm_desc ?>">
                            <?= $row2->sfsm ?>
                          </p>
                        </div>
                        <div class="col-lg-2 col-md-12 col-sm-12 row">
                          <select class="form-select" onchange="return sfa(<?= $row->id ?>, <?= $row2->id ?>,<?= $msme_id ?>, this.value)" required>
                            <option value="" selected disabled>-- select --</option>
                            <option value="10" <?= $conn->query("SELECT * FROM responses WHERE sfm_id=$row->id and sfsm_id=$row2->id and msme_id=$msme_id and value = 10")->num_rows ? 'selected' : '' ?>>Very high</option>
                            <option value="9" <?= $conn->query("SELECT * FROM responses WHERE sfm_id=$row->id and sfsm_id=$row2->id and msme_id=$msme_id and value = 9")->num_rows ? 'selected' : '' ?>>Less than Very High</option>
                            <option value="8" <?= $conn->query("SELECT * FROM responses WHERE sfm_id=$row->id and sfsm_id=$row2->id and msme_id=$msme_id and value = 8")->num_rows ? 'selected' : '' ?>>Better than High</option>
                            <option value="7" <?= $conn->query("SELECT * FROM responses WHERE sfm_id=$row->id and sfsm_id=$row2->id and msme_id=$msme_id and value = 7")->num_rows ? 'selected' : '' ?>>High</option>
                            <option value="6" <?= $conn->query("SELECT * FROM responses WHERE sfm_id=$row->id and sfsm_id=$row2->id and msme_id=$msme_id and value = 6")->num_rows ? 'selected' : '' ?>>Better than Average</option>
                            <option value="5" <?= $conn->query("SELECT * FROM responses WHERE sfm_id=$row->id and sfsm_id=$row2->id and msme_id=$msme_id and value = 5")->num_rows ? 'selected' : '' ?>>Average</option>
                            <option value="4" <?= $conn->query("SELECT * FROM responses WHERE sfm_id=$row->id and sfsm_id=$row2->id and msme_id=$msme_id and value = 4")->num_rows ? 'selected' : '' ?>>Better than Low</option>
                            <option value="3" <?= $conn->query("SELECT * FROM responses WHERE sfm_id=$row->id and sfsm_id=$row2->id and msme_id=$msme_id and value = 3")->num_rows ? 'selected' : '' ?>>Low</option>
                            <option value="2" <?= $conn->query("SELECT * FROM responses WHERE sfm_id=$row->id and sfsm_id=$row2->id and msme_id=$msme_id and value = 2")->num_rows ? 'selected' : '' ?>>Better than Very Low</option>
                            <option value="1" <?= $conn->query("SELECT * FROM responses WHERE sfm_id=$row->id and sfsm_id=$row2->id and msme_id=$msme_id and value = 1")->num_rows ? 'selected' : '' ?>>Very Low</option>
                          </select>
                        </div>
                      </div>
                      <hr>
                    <?php
                    }
                    ?>
                  </div>
                </div>
              </div>

            </div>
          <?php
          }
          ?>
          <div class="mb-3 text-end">
            <a href="assessment.php" class="btn btn-primary">Prev</a>
            <button class="btn btn-primary">Next</button>
          </div>
        </form>
      </div>
    </div>
  </section>
  <script>
    function sfa(sfm_id, sfsm_id, msme_id, value) {
      $.ajax({
        url: "assets/components/includes/process.php",
        method: "POST",
        data: {
          sfm_id: sfm_id,
          sfsm_id: sfsm_id,
          msme_id: msme_id,
          value: value,
          sfa: '',
        },
        dataType: "json",
        success: function(response) {
          console.log("message");
        },
      });
    }
  </script>
</main><!-- End #main -->
<?php
require_once("assets/components/templates/modals.php");
require_once("assets/components/templates/footer.php");
?>