
<div class="container">
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >
          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title"><?php echo escape($data->username); ?></h3>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class=" col-md-9 col-lg-9 ">
                  <table class="table table-user-information">
                    <tbody>
                      <tr>
                        <td>Username :</td>
                        <td><?php echo escape($data->username); ?></td>
                      </tr>
                      <tr>
                        <td>Date Joined :</td>
                        <td><?php echo escape($data->joined); ?></td>
                      </tr>
                    </tbody>
                  </table>
                  <a href="update-account.php" class="btn btn-primary">Update Information</a>
                  <a href="delete-account.php" class="btn btn-danger">Delete Account</a>
                  <a href="logout.php" class="btn btn-danger">Logout</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
