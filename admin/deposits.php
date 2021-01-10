<?php

if ( isset($_GET['approved']) ) {
    $is_approved = $_GET['approved'];
    if ( $is_approved == 'true' ) {
        $is_approved = true;
    } else if ( $is_approved == 'false' ) {
        $is_approved = false;
    }
}

$is_approved = $is_approved ?? false;
$prefix = $is_approved ? 'Approved' : 'UnApproved';
$title = $prefix.' Deposits';
require_once "./components/nav.php";

$sql = !$is_approved ? "SELECT d.*, u.username FROM deposits AS d LEFT JOIN users AS u ON d.user_id = u.id WHERE approved_at IS NULL ORDER BY d.created_at DESC" : "SELECT d.*, u.username FROM deposits AS d LEFT JOIN users AS u ON d.user_id = u.id WHERE approved_at IS NOT NULL ORDER BY d.created_at DESC";
$result = $link->query($sql);
$deposits = [];
if ( $result->num_rows ) {
    while($res = $result->fetch_object())
        array_push($deposits, $res);
}

?>

<div class="page-header">
    <?php $heading = trim(explode('|', $title)[0]) ?>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="title">
                <h4><?php echo $heading ?? '' ?></h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="./dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo $heading ?? '' ?></li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="card-box pd-20 height-100-p mb-30">
    <table class="table table-responsive">
        <thead>
            <th scope="col">#</th>
            <th scope="col">Username</th>
            <th scope="col">Amount</th>
            <th scope="col">Created On</th>
            <?php if ($is_approved) echo "<th scope='col'>Approved At</th>" ?>
            <th scope="col">Actions</th>
        </thead>
        <?php if ( count($deposits) ) { ?>
            <tbody>
                <?php for ( $i = 0; $i < count($deposits); $i++ ) { ?>
                    <tr>
                        <td><?php echo  $i+1 ?></td>
                        <td><?php echo $deposits[$i]->username ?></td>
                        <td><?php echo $deposits[$i]->amount ?></td>
                        <td><?php echo date('d M, Y h:i a', strtotime($deposits[$i]->created_at)) ?? '' ?></td>
                        <?php if ($is_approved) { ?>
                            <td><?php echo date('d M, Y h:i a', strtotime($deposits[$i]->approved_at)) ?? '' ?></td>
                        <?php } ?>
                        <td>
                            <button type='button' class="btn btn-primary btn-sm" onclick="view('<?php echo $deposits[$i]->image_path ?>')">View Proof</button>
                            <button type='button' class="btn btn-secondary btn-sm" onclick="approve('<?php echo $deposits[$i]->id ?>')"><?php echo $is_approved ? 'UnApprove' : 'Approve' ?></button>
                            <form action="./forms/deposits.php<?php echo !empty($_GET) ? '?'.http_build_query($_GET) : '' ?>" class="d-inline" id="form-<?php echo $deposits[$i]->id ?>" method='post'>
                                <input type="hidden" name='deposit_id' value="<?php echo $deposits[$i]->id ?>">
                                <input type="hidden" name='approved' value="<?php echo $is_approved ? 'true' : 'false' ?>">
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        <?php } ?>
    </table>					
</div>

<?php include_once "./components/auth_footer.php" ?>

<!-- Modal -->
<div class="modal fade" id="proofModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Payment Proof</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <img id="proof" src="" alt="proof" class="image image-fluid">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
    const view = (src) => {
        let img = document.querySelector('#proof');
        img.setAttribute('src', './../uploads/proofs/'+src)
        $('#proofModal').modal('show');
    }

    const approve = (id) => {
        let form = document.querySelector('#form-'+id)
        if ( confirm("<?php echo !$is_approved ? 'Approve' : 'UnApprove' ?> Deposit?") )
            form.submit();
    }
</script>