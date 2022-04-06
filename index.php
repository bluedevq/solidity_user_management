<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>User management</title>

    <!-- Bootstrap -->
    <link href="css/lib/bootstrap.min.css" rel="stylesheet">
    <link href="css/lib/fontawesome.min.css" rel="stylesheet">
    <link href="css/lib/brands.min.css" rel="stylesheet">
    <link href="css/lib/regular.min.css" rel="stylesheet">
    <link href="css/lib/solid.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="container" style="width: 650px;">
    <div class="row">
        <div class="col-lg-12 text-center">
            <h1>List user</h1>
            <hr/>
            <br/>
            <div id="content">
                <div class="form-group">
                    <div class="input-group">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#user-info">Add user</button>
                    </div>
                </div>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Gender</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody class="list-user">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div style="position: absolute; top: 50px; right: 20px;">
    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-body"><span class="message"></span></div>
    </div>
</div>

<div class="modal" id="user-info" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">User info</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form">
                    <label for="">Name</label><input class="form-control input-lg" name="name">
                    <label for="">Gender</label><input class="form-control input-lg" name="gender">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary save">Save</button>
                <input type="hidden" class="user-id" name="id" value="">
            </div>
        </div>
    </div>
</div>

<script src="js/jquery-3.6.0.min.js"></script>
<script src="js/jquery-3.3.1.slim.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/web3.min.js"></script>
<script>
    $(document).ready(function () {
        $('.toast').toast({
            delay: 1500
        });
    });
    // Initialize Web3
    if (typeof web3 !== 'undefined') {
        web3 = new Web3(web3.currentProvider);
    } else {
        web3 = new Web3(new Web3.providers.HttpProvider('http://127.0.0.1:7545'));
    }

    // Set Account
    web3.eth.defaultAccount = web3.eth.accounts[0];

    // Set Contract Abi
    var contractAbi = [
        {
            "inputs": [
                {
                    "internalType": "string",
                    "name": "name",
                    "type": "string"
                },
                {
                    "internalType": "string",
                    "name": "gender",
                    "type": "string"
                }
            ],
            "name": "create",
            "outputs": [],
            "stateMutability": "nonpayable",
            "type": "function"
        },
        {
            "inputs": [
                {
                    "internalType": "uint256",
                    "name": "id",
                    "type": "uint256"
                }
            ],
            "name": "findUser",
            "outputs": [
                {
                    "components": [
                        {
                            "internalType": "uint256",
                            "name": "id",
                            "type": "uint256"
                        },
                        {
                            "internalType": "string",
                            "name": "name",
                            "type": "string"
                        },
                        {
                            "internalType": "string",
                            "name": "gender",
                            "type": "string"
                        }
                    ],
                    "internalType": "struct Users.User",
                    "name": "",
                    "type": "tuple"
                }
            ],
            "stateMutability": "view",
            "type": "function"
        },
        {
            "inputs": [],
            "name": "list",
            "outputs": [
                {
                    "components": [
                        {
                            "internalType": "uint256",
                            "name": "id",
                            "type": "uint256"
                        },
                        {
                            "internalType": "string",
                            "name": "name",
                            "type": "string"
                        },
                        {
                            "internalType": "string",
                            "name": "gender",
                            "type": "string"
                        }
                    ],
                    "internalType": "struct Users.User[]",
                    "name": "",
                    "type": "tuple[]"
                }
            ],
            "stateMutability": "view",
            "type": "function"
        },
        {
            "inputs": [
                {
                    "internalType": "uint256",
                    "name": "id",
                    "type": "uint256"
                }
            ],
            "name": "remove",
            "outputs": [],
            "stateMutability": "nonpayable",
            "type": "function"
        },
        {
            "inputs": [
                {
                    "internalType": "uint256",
                    "name": "id",
                    "type": "uint256"
                },
                {
                    "internalType": "string",
                    "name": "name",
                    "type": "string"
                },
                {
                    "internalType": "string",
                    "name": "gender",
                    "type": "string"
                }
            ],
            "name": "update",
            "outputs": [],
            "stateMutability": "nonpayable",
            "type": "function"
        }
    ];

    // Set Contract Address
    var contractAddress = '0xEa09cC10a0eA5E408D29e40Dde0978277f2F713e';

    // Set the Contract
    var UserContract = new web3.eth.Contract(contractAbi, contractAddress);

    // Display list users
    reloadTable();

    // change user info
    $('#user-info .save').on('click', function (event) {
        event.preventDefault();
        var id = $('#user-info .user-id').val();
        if (id) {
            updateUser(id);
        } else {
            createUser();
        }
    })

    // delete user
    $(document).on('click', '.delete-user', function (event) {
        event.preventDefault();
        deleteUser($(this).data('id'));
    })

    // show user info
    $(document).on('click', '.edit-user', function (event) {
        event.preventDefault();
        findUser($(this).data('id'));
    })

    function reloadTable() {
        UserContract.methods.list().call().then(function (result) {
            var html = '';
            for (var i = 0; i < result.length; i++) {
                if (!result[i].name) {
                    continue;
                }
                html += '<tr class="' + result[i].id + '">'
                    + '<td>' + result[i].id + '</td>'
                    + '<td>' + result[i].name + '</td>'
                    + '<td>' + result[i].gender + '</td>'
                    + '<td>'
                    + '<a href="javascript:void(0)" class="edit-user" data-toggle="modal" data-target="#user-info" data-id="' + result[i].id + '"><i class="fas fa-pen-square"></i></a>&nbsp;&nbsp;'
                    + '<a href="javascript:void(0)" class="delete-user" data-toggle="modal" data-target="#user-info" data-id="' + result[i].id + '"><i class="fas fa-trash"></i></a>'
                    + '</td>'
                    + '</tr>';
            }
            $('.list-user').html(html);
        });
    }

    function createUser() {
        UserContract.methods.create($('input[name="name"]').val(), $('input[name="gender"]').val()).send({
            from: '0x3a0d12118714fE9983478E97D391Dc9D7B450881',
            gas: 3000000
        }).then(function () {
            $('input[name="name"]').val('');
            $('input[name="gender"]').val('');
            $('#user-info').modal('hide');
            reloadTable();
            $('.toast .toast-body .message').addClass('text-success').text('Add user success');
            $('.toast').toast('show');
        });
    }

    function findUser(id) {
        UserContract.methods.findUser(id).call().then(function (result) {
            $('#user-info .user-id').val(result.id);
            $('input[name="name"]').val(result.name);
            $('input[name="gender"]').val(result.gender);
        });
    }

    function updateUser(id) {
        UserContract.methods.update(id, $('input[name="name"]').val(), $('input[name="gender"]').val()).send({
            from: '0x3a0d12118714fE9983478E97D391Dc9D7B450881',
            gas: 3000000
        }).then(function () {
            $('input[name="name"]').val('');
            $('input[name="gender"]').val('');
            $('#user-info .user-id').val('');
            $('#user-info').modal('hide');
            reloadTable();
            $('.toast .toast-body .message').addClass('text-success').text('Update user success');
            $('.toast').toast('show');
        });
    }

    function deleteUser(id) {
        UserContract.methods.remove(id).send({
            from: '0x3a0d12118714fE9983478E97D391Dc9D7B450881',
            gas: 3000000
        }).then(function () {
            reloadTable();
            $('.toast .toast-body .message').addClass('text-success').text('Delete user success');
            $('.toast').toast('show');
        });
    }
</script>
</body>
</html>