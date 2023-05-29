<?php
require "todoListBackend.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do App</title>

    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css">

    <!-- Add Bootstrap JavaScript (Optional) -->
    <!-- Note: Bootstrap 5 doesn't require jQuery, but you can still include it if needed -->
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <section class="vh-100" style="background-color: #eee;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-lg-9 col-xl-7">
                    <div class="card rounded-3">
                        <div class="card-body p-4">

                            <?php if (!empty($message)) : ?>
                                <div class="alert alert-success" role="alert">
                                    <?= $message; ?>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($errorMessage)) : ?>
                                <div class="alert alert-danger" role="alert">
                                    <?= $errorMessage; ?>
                                </div>
                            <?php endif; ?>

                            <h4 class="text-center my-3 pb-3">To Do App</h4>

                            <form class="row row-cols-lg-auto g-3 justify-content-center align-items-center mb-4 pb-2" method="POST">
                                <div class="col-12">
                                    <div class="form-outline">
                                        <input type="text" name="createTodo" id="createTodo" class="form-control" placeholder="Enter task here..." required />
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" name="addTodo" class="btn btn-primary">Save</button>
                                </div>

                            </form>

                            <div class="table-responsive">
                                <table class="table mb-6">
                                    <thead>
                                        <tr>
                                            <th scope="col">No.</th>
                                            <th scope="col">Todo item</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($todolists as $todolist) : ?>
                                            <tr>
                                                <th scope="row"><?= $todolist->todoId; ?></th>
                                                <td><?= $todolist->todoItem; ?></td>
                                                <td> <?php if ($todolist->statusWord == 'In Progress') : ?>
                                                        <span class="text-warning"><?= $todolist->statusWord; ?></span>
                                                    <?php elseif ($todolist->statusWord == 'Finished') : ?>
                                                        <span class="text-success"><?= $todolist->statusWord; ?></span>
                                                    <?php else : ?>
                                                        <?= $todolist->status; ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if ($todolist->statusWord !== 'Finished') : ?>
                                                        <!--edit button-->
                                                        <a href="#updateTodo_<?= $todolist->todoId; ?>" class="btn btn-outline-primary" data-bs-toggle="modal">Edit</a>


                                                        <!--edit button modal-->
                                                        <div class="modal fade" id="updateTodo_<?= $todolist->todoId; ?>" tabindex="-1" aria-labelledby="todoUpdateModalLabel_<?= $todolist->todoId; ?>" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="todoUpdateModalLabel_<?= $todolist->todoId; ?>">Update To Do No. <?= $todolist->todoId; ?></h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <form method="POST" action="todoListFrontEnd.php?UpdateTodoListId=<?= $todolist->todoId; ?>">
                                                                        <div class="modal-body">
                                                                            <div class="form-group">
                                                                                <label for="todoItem">To Do Item:</label>
                                                                                <input type="text" name="todoItem" id="todoItem" class="form-control" value="<?= $todolist->todoItem; ?>" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                            <input type="submit" name="updateTodo" class="btn btn-primary" value="Update To Do">
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!--delete button-->
                                                        <a href="#deleteTodo_<?= $todolist->todoId; ?>" class="btn btn-outline-danger" data-bs-toggle="modal">Delete</a>

                                                        <div class="modal fade" id="deleteTodo_<?= $todolist->todoId; ?>" tabindex="-1" aria-labelledby="todoDeleteModalLabel_<?= $todolist->todoId; ?>" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h1 class="modal-title fs-5" id="todoDeleteModalLabel_<?= $todolist->todoId; ?>">Delete To Do No. <?= $todolist->todoId; ?></h1>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <form method="post" action="todoListFrontEnd.php?DeleteTodoListId=<?= $todolist->todoId; ?>">
                                                                        <div class="modal-body">
                                                                            <span>Are you sure you want to delete this To Do record?</span>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                            <input type="submit" name="deleteTodo" class="btn btn-danger" value="Delete To Do" />
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!--finished button-->
                                                        <a href="#finishedTodo_<?= $todolist->todoId; ?>" class="btn btn-outline-success" data-bs-toggle="modal">Finished</a>
                                                        <!--finished button modal-->
                                                        <div class="modal fade" id="finishedTodo_<?= $todolist->todoId; ?>" tabindex="-1" aria-labelledby="todoFinishedModalLabel_<?= $todolist->todoId; ?>" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h1 class="modal-title fs-5" id="todoFinishedModalLabel_<?= $todolist->todoId; ?>">Finished To Do No. <?= $todolist->todoId; ?></h1>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <form method="post" action="todoListFrontEnd.php?FinishedTodoListId=<?= $todolist->todoId; ?>">
                                                                        <div class="modal-body">
                                                                            <span>Are you sure you are finished with this record?</span>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                            <input type="submit" name="finishedTodo" class="btn btn-success" value="Yes, I'm finished" />
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php else : ?>
                                                        <button class="btn btn-secondary" disabled>Already Finished</button>

                                                        <!--remove button-->
                                                        <a href="#removeTodo_<?= $todolist->todoId; ?>" class="btn btn-danger" data-bs-toggle="modal">Remove</a>

                                                        <div class="modal fade" id="removeTodo_<?= $todolist->todoId; ?>" tabindex="-1" aria-labelledby="todoRemoveModalLabel_<?= $todolist->todoId; ?>" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h1 class="modal-title fs-5" id="todoRemoveModalLabel_<?= $todolist->todoId; ?>">Remove To Do No. <?= $todolist->todoId; ?></h1>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <form method="post" action="todoListFrontEnd.php?RemoveTodoListId=<?= $todolist->todoId; ?>">
                                                                        <div class="modal-body">
                                                                            <span>Are you sure you want to remove this To Do record?</span>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                            <input type="submit" name="removeTodo" class="btn btn-danger" value="Remove To Do" />
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>