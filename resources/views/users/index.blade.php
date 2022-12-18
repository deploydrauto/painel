<x-app-layout>
    <style>
        .accordion {
            background-color: #eee;
            color: #444;
            cursor: pointer;
            padding: 18px;
            width: 100%;
            border: none;
            text-align: left;
            outline: none;
            font-size: 15px;
            transition: 0.4s;

        }

        .active,
        .accordion:hover {
            background-color: #ccc;
        }

        .panel {
            padding: 0 18px;
            display: none;
            background-color: white;
        }

        .modal {
            transition: opacity 0.25s ease;
        }

        body.modal-active {
            overflow-x: hidden;
            overflow-y: visible !important;
        }
    </style>
    <x-slot name="header">
        <div class="flex justify-end">
            <x-primary-button data-bs-toggle="modal" data-bs-target="#user_add_modal">{{ __('+ Adicionar') }}
            </x-primary-button>
        </div>

    </x-slot>

    <div class="max-w-2xl mx-auto">

        <div class="flex flex-col">
            <div class="overflow-x-auto shadow-md sm:rounded-lg">
                <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden ">
                        <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-700">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th scope="col"
                                        class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                        Usuario
                                    </th>
                                    <th scope="col"
                                        class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                        email
                                    </th>
                                    <th scope="col"
                                        class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                        Statistic
                                    </th>


                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                @foreach ($users as $user)
                                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">
                                        <td data-bs-toggle="modal" data-bs-target="#user_edit_modal"
                                            onClick="editUser({{ $user->id }})"
                                            class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $user->name }}
                                        </td>
                                        <td data-bs-toggle="modal" data-bs-target="#user_edit_modal"
                                            onClick="editUser({{ $user->id }})"
                                            class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap dark:text-white">
                                            {{ $user->email }}
                                        </td>
                                        <td
                                            class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap dark:text-white">
                                            <p>
                                                <x-primary-button data-bs-toggle="modal"
                                                    data-bs-target="#exampleModalXl"
                                                    onClick="fetchUserClients({{ $user->id }})" class="mt-1">
                                                    Clientes: {{ $user->clientes }}
                                                </x-primary-button>
                                            </p>
                                            <p>
                                                <x-primary-button class="mt-1" data-bs-toggle="modal"
                                                    data-bs-target="#users_games"
                                                    onClick="fetchGamesUser({{ $user->id }})"> Games :
                                                    {{ $user->games }}
                                                </x-primary-button>
                                            </p>
                                            <p>
                                                <x-primary-button class="mt-1" data-bs-toggle="modal"
                                                    data-bs-target="#webhooks_modal"
                                                    onclick="fetchWebhooksUser({{ $user->id }})"> WebHooks :
                                                    {{ $user->webhooks }}
                                                </x-primary-button>
                                            </p>

                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </div>

    @include('modals.user_add')
    @include('modals.clientes_user')
    @include('modals.games_user')
    @include('modals.webhooks_user')
    @include('modals.user_edit')



</x-app-layout>

<script>
    function loadModal() {
        // showModal('user_add')
        console.log(document.querySelectorAll('user_add'))

    }
    // replace action of form
    function editUser(id) {
        var form = document.getElementById('user-edit-form');
        fetch('/users/show/' + id)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                form.edit_user_id.value = id;
                form.edit_name.value = data.name;
                form.edit_email.value = data.email;
                form.edit_password.value = data.password;
                form.edit_password_confirmation.value = data.password;
            });



        // showModal('user-edit')
    }

    function storeClient() {

        let form = document.getElementById('client-form');


        let formData = new FormData();
        formData.body
        let url = '/client/new';
        let method = 'POST';
        let data = {
            _token: '{{ csrf_token() }}',
            method: method,
            body: formData
        }
        fetch(url, data)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.status == 'success') {
                    alert('Cliente cadastrado com sucesso');
                    form.reset();
                    // hideModal('client');
                }
            });
    }

    // store client with json in /client/new post method
    function storeClientJson() {

        let form = document.getElementById('client-form');

        $.ajax({
            url: "{{ route('client.store') }}",
            type: "POST",
            async: false,
            data: {
                _token: $('[name=_token]').val(),
                id_user: form.user_id.value,
                body: {
                    _token: '{{ csrf_token() }}',
                    nome: form.nome.value,
                    email: form.email.value,
                    telefone: form.telefone.value,
                    client_inicio: form.client_inicio.value,
                    id_user: form.user_id.value,
                    id_game: form.games_select.value,
                    id_plan: form.plans_select.value,
                },
            },
            success: function(data) {
                fetchUserClients(form.user_id.value);
                alert('Cliente cadastrado com sucesso');
                form.reset();
                hideModal('client');
            }
        });

    }

    function fetchUserClients(id) {

        document.getElementById('user_id').value = id;

        fetch('/users/clientes/' + id)
            .then(response => response.json())
            .then(data => {
                let table = document.getElementById('user-clients-table');
                table.innerHTML = '';
                console.log(data);
                data.forEach(client => {
                    let row = document.createElement('tr');
                    row.innerHTML = `
                <td class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap dark:text-white">
                    <p>Nome: ${client.nome}</p>
                    <p>Email: ${client.email}</p>
                    <p>Telefone: ${client.telefone}</p>
                    <p>Ativação:${client.data_atv}</p>
                    <p>Meio:${client.meio}</p></td>
                <td class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap dark:text-white">${client.name}</td>
                <td class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap dark:text-white">${client.inicio}</td>
                <td class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap dark:text-white">${client.termino}</td>
                <td class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap dark:text-white">
                    ${client.status == 1 ? '<button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="desativarCliente('+client.id+')">Ativo</button>':'<button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" onclick="ativarCliente('+client.id+')">Desativado</button>'}
                </td>
                <td  class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap dark:text-white">
                    <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="deleteClient(${client.id})">
                        <svg class="w-6 h-6" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                    </td>

`;
                    table.appendChild(row);
                });
            });
    }


    // GAME BOTS
    function fetchGamesUser(id) {
        fetchNoGameBots(id)
        fetch('/user/gamesuser/' + id)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                document.getElementById('user_id').value = id;
                let table = document.getElementById('games-user-table');
                table.innerHTML = '';
                data.forEach(game => {
                    console.log(game);
                    let row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap dark:text-white">${game.id}</td>
                        <td class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap dark:text-white">${game.name}</td>
                        <td class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap dark:text-white">
                            <button  onClick="deleteGameUser(${game.id})" >Delete</button></td>

                    `;
                    table.appendChild(row);
                });
            });
    }

    function deleteGameUser(id) {
        let id_user = +document.getElementById('user_id').value

        $.ajax({
            url: '/user/deletegameuser/' + id,
            type: "POST",
            async: false,
            data: {
                _token: $('[name=_token]').val(),
                id_user: +id_user,
                id: +id,

                body: {
                    _token: '{{ csrf_token() }}',
                    id_user: +id_user,
                    id: +id,

                },
            },
            success: function(data) {
                fetchGamesUser(id_user);
                fetchNoGameBots(id_user);
                // alert('Cliente cadastrado com sucesso');

            }
        });
    }
    // stor game to user
    function storeGameUser() {

        // get vaule of optiosn select of game_no_have
        let datas = document.getElementById('game_no_have').value;
        let id_user = +document.getElementById('user_id').value

        $.ajax({
            url: "{{ route('user.games.store') }}",
            type: "POST",
            async: false,
            data: {
                _token: $('[name=_token]').val(),
                id_user: +id_user,
                id_game: +datas,

                body: {
                    _token: '{{ csrf_token() }}',
                    id_user: +id_user,
                    id_game: +datas,

                },
            },
            success: function(data) {
                fetchGamesUser(id_user);
                fetchNoGameBots(id_user);
                alert('Cliente cadastrado com sucesso');

            }
        });
    }

    function fetchNoGameBots(id) {
        fetch('/user/nogameuser/' + id)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                console.log(data.length)
                // add options to game_no_have select
                let select = document.getElementById('game_no_have');
                select.innerHTML = '';
                if (data.length == 0) {
                    let option = document.createElement('option');
                    option.value = '';
                    option.innerHTML = 'Não há jogos para adicionar';
                    select.appendChild(option);
                } else if (data.length == undefined) {
                    let option = document.createElement('option');
                    option.value = data.id;
                    option.innerHTML = data.name;
                    select.appendChild(option);
                } else {
                    data.forEach(game => {
                        let option = document.createElement('option');
                        option.value = game.id;
                        option.innerHTML = game.name;
                        select.appendChild(option);
                    });
                }


            });
    }

    // fetch webhooks user
    function fetchWebhooksUser(id) {
        fetchGamesOfUsers(id)
        fetch('/user/webhooks/' + id)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                document.getElementById('user_id').value = id;
                let table = document.getElementById('webhooks-table');
                table.innerHTML = '';
                data.forEach(webhook => {
                    console.log(webhook);
                    let row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap dark:text-white">${webhook.id}</td>
                        <td class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap dark:text-white">${webhook.method}</td>
                        <td class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap dark:text-white">${webhook.game_name}</td>
                        <td class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap dark:text-white">${webhook.url}</td>

                        <td class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap dark:text-white">
                            <button  onClick="deleteWebhookUser(${webhook.id})" >Delete</button></td>

                    `;
                    table.appendChild(row);
                });
            });
    }

    function storeWebhook() {

        // get vaule of optiosn select of game_no_have
        let datas = document.getElementById('games_list').value;
        let id_user = +document.getElementById('user_id').value
        let methodo = document.getElementById('methodos').value

        $.ajax({
            url: "{{ route('user.webhook.store') }}",
            type: "POST",
            async: false,
            data: {
                _token: $('[name=_token]').val(),
                id_user: +id_user,
                id_game: +datas,
                method: methodo,


                body: {
                    _token: '{{ csrf_token() }}',
                    id_user: +id_user,
                    id_game: +datas,
                    method: methodo,

                },
            },
            success: function(data) {
                fetchGamesUser(id_user);
                fetchNoGameBots(id_user);
                alert('Cliente cadastrado com sucesso');

            }
        });
    }

    function fetchGamesOfUsers(id) {
        fetchNoGameBots(id)
        fetch('/user/gamesuser/' + id)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                document.getElementById('user_id').value = id;
                let select = document.getElementById('games_list');
                select.innerHTML = '';
                if (data.length == 0) {
                    let option = document.createElement('option');
                    option.value = '';
                    option.innerHTML = 'Não há jogos para adicionar';
                    select.appendChild(option);
                } else if (data.length == undefined) {
                    let option = document.createElement('option');
                    option.value = data.id_game;
                    option.innerHTML = data.name;
                    select.appendChild(option);
                } else {
                    data.forEach(game => {
                        let option = document.createElement('option');
                        option.value = game.id_game;
                        option.innerHTML = game.name;
                        select.appendChild(option);
                    });
                }

            });
    }

    function deleteWebhookUser(id) {
        let id_user = +document.getElementById('user_id').value

        $.ajax({
            url: '/user/webhook/delete/' + id,
            type: "POST",
            async: false,
            data: {
                _token: $('[name=_token]').val(),
                id_user: +id_user,
                id: +id,

                body: {
                    _token: '{{ csrf_token() }}',
                    id_user: +id_user,
                    id: +id,

                },
            },
            success: function(data) {
                fetchGamesUser(id_user);
                fetchNoGameBots(id_user);
                // alert('Cliente cadastrado com sucesso');

            }
        });
    }

    function deleteClient(id) {
        let id_user = +document.getElementById('user_id').value

        $.ajax({
            url: '/client/delete/' + id,
            type: "POST",
            async: false,
            data: {
                _token: $('[name=_token]').val(),
                id_user: +id_user,
                id: +id,

                body: {
                    _token: '{{ csrf_token() }}',
                    id_user: +id_user,
                    id: +id,

                },
            },
            success: function(data) {
                fetchUserClients(id_user);
                fetchGamesUser(id_user);
                fetchNoGameBots(id_user);
                alert('Cliente apagado com sucesso');

            }
        });
    }

    function ativarCliente(id) {
        let id_user = +document.getElementById('user_id').value

        $.ajax({
            url: '/cliente/ativar/' + id,
            type: "POST",
            async: false,
            data: {
                _token: $('[name=_token]').val(),
                id_user: +id_user,
                id: +id,

                body: {
                    _token: '{{ csrf_token() }}',
                    id_user: +id_user,
                    id: +id,

                },
            },
            success: function(data) {
                fetchUserClients(id_user);
                // fetchNoGameBots(id_user);
                alert('Cliente Ativado');

            }
        });
    }

    function desativarCliente(id) {
        let id_user = +document.getElementById('user_id').value

        $.ajax({
            url: '/cliente/desativar/' + id,
            type: "POST",
            async: false,
            data: {
                _token: $('[name=_token]').val(),
                id_user: +id_user,
                id: +id,

                body: {
                    _token: '{{ csrf_token() }}',
                    id_user: +id_user,
                    id: +id,

                },
            },
            success: function(data) {
                fetchUserClients(id_user);
                // fetchNoGameBots(id_user);
                alert('Cliente Desativado');

            }
        });
    }
</script>
