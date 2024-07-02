<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stick on | Stick your message on !</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assect/css/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" href="logout.php">logout</a>
    </li>
  </ul>
</nav>
    <h1 class="text-center my-4">Stick on</h1>
    <div class="container">
        <div id="message-form" class="mb-4">
            <form id="postMessageForm" method="POST" action="submit_message.php" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="message-content" class="form-label">Leave a message</label>
                    <textarea class="form-control" id="message-content" rows="3" name="content" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="message-files" class="form-label">Select file</label>
                    <input class="form-control" type="file" id="message-files" multiple accept=".pdf,.doc,.docx,.jpg" name="files[]">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
        <div id="messages">
            <h4>Message board</h4>
           
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "xd405060";
                $dbname = "dbt";
                session_start();
                $un=isset($_SESSION['username'])?$_SESSION['username']:'';
                
                //new一個object資料庫連接
                $conn = new mysqli($servername, $username, $password, $dbname);
                    $sql = "SELECT * FROM messages ORDER BY created_at DESC";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        
                        //循環顯示內容
                        while($row = $result->fetch_assoc()) {
                            eCHO '<BR>';
                            echo  $row["users"].'&nbsp&nbsp<span style="font-size:10px">'.$row["created_at"].'</span>' ;
                            if($un==$row['users']){
                            echo "
                                    <button class='btn btn-secondary edit-btn' data-id='".$row["id"]."' data-content='".$row["content"]."'>Edit</button>
                                    <form method='POST' action='delete_message.php' style='display:inline;'>
                                        <input type='hidden' name='id' value='".$row["id"]."'>
                                        <button type='submit' class='btn btn-danger'>Delete</button>
                                    </form>
                                  ";
                         }
                           eCHO '<BR>'; echo  $row["content"];
                            if (!empty($row["files"])) {
                                $files = explode(",", $row["files"]);
                                 eCHO '<BR>';
                                foreach ($files as $file) {
                                    echo "<a href='$file'>$file</a> &nbsp";
                                }
                            }
                           eCHO '<BR><hr>';
                        }
                    } else {
                        echo "<tr><td colspan='4'>No message</td></tr>";
                    }
                    $conn->close();
                ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- 編輯留言 Modal -->
    <div class="modal fade" id="editMessageModal" tabindex="-1" aria-labelledby="editMessageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editMessageModalLabel">Edit message</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editMessageForm" method="POST" action="update_message.php" enctype="multipart/form-data">
                        <input type="hidden" id="edit-message-id" name="id">
                        <div class="mb-3">
                            <label for="edit-message-content" class="form-label">Content</label>
                            <textarea class="form-control" id="edit-message-content" rows="3" name="content" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit-message-files" class="form-label">Select file</label>
                            <input class="form-control" type="file" id="edit-message-files" multiple accept=".pdf,.doc,.docx,.jpg" name="files[]">
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="session_timer.js"></script>
    <script>
        $(document).ready(function() {
            $('.edit-btn').click(function() {
                var id = $(this).data('id');
                var content = $(this).data('content');
                $('#edit-message-id').val(id);
                $('#edit-message-content').val(content);
                $('#editMessageModal').modal('show');
            });
        });
    </script>
</body>
</html>
