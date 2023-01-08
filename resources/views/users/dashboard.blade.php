<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>



    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">


                    @can('admin')
                    <h1>
                        {{ auth()->user()->isadmin   ? 'Administrador' : 'Usuario'}}
                    </h1>
                    @endcan
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
                                                        <td onClick="editUser({{ $user->id }})"
                                                            class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                            {{ $user->name }}
                                                        </td>
                                                        <td onClick="editUser({{ $user->id }})"
                                                            class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap dark:text-white">
                                                            {{ $user->email }}
                                                        </td>
                                                        <td
                                                            class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap dark:text-white">
                                                            <p>
                                                                <x-primary-button data-bs-toggle="modal"
                                                                    data-bs-target="#exampleModalXl"
                                                                    onClick="fetchUserClients({{ $user->id }})" class="mt-1">
                                                                    Clientes: T:{{ $user->clientes }} A:  {{ $user->ativos }}  I:  {{ $user->inativos }}
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
                                                                <x-primary-button class="mt-1"   data-bs-toggle="modal"
                                                                data-bs-target="#webhooks_modal" onclick="fetchWebhooksUser({{ $user->id }})"> WebHooks : {{ $user->webhooks }}
                                                                </x-primary-button>
                                                            </p>

                                                        </td>

                                                    </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                    <div>
                                        <div>
                                            <canvas id="myChart"></canvas>
                                          </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                    @include('modals.user_add')
                    @include('modals.clientes_user')
                    @include('modals.games_user')
                    @include('modals.webhooks_user')





                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function () {
    

    const selectElement = document.querySelector('.ice-cream');

selectElement.addEventListener('change', (event) => {

    if ( event.target.value == 5) {
            // show plan_custom
            console.log("selecionado")
            document.querySelector('.divteste').classList.remove('hidden')
        } else {
            // hide plan_custom
            document.querySelector('.divteste').classList.add('hidden')
        }
//   const result = document.querySelector('.result');
//   result.textContent = `You like ${event.target.value}`;
});

    const ctx = document.getElementById('myChart');
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: {!!json_encode($graphic_label, JSON_UNESCAPED_UNICODE)!!},
        datasets: [

        {
          label: 'Usuarios Ativos por Bot',
          color: 'green',
            backgroundColor: 'rgba(104,195,111,0.7)',
          data: {!!  json_encode($grapnic_value_ative, JSON_UNESCAPED_UNICODE)!!},
          borderWidth: 1
        },
        {
          label: 'Usuarios Inativos por Bot',
          data: {!!  json_encode($grapnic_value_inative, JSON_UNESCAPED_UNICODE)!!},
          color: 'red',
            backgroundColor: 'rgba(241,50,16,0.7)',

          borderWidth: 1
        }]
      },
      options: {
        scales: {
            x: {
        stacked: true,
      },
      y: {
        stacked: true,
        beginAtZero: true
      }

        }
      }
    });
    Chart.defaults.color = "#ffffff";
});





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
                form.name.value = data.name;
                form.email.value = data.email;
                form.password.value = data.password;
                form.password_confirmation.value = data.password_confirmation;
            });
        form.action = '/users/edit/' + id;


        showModal('user-edit')
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
        if(form.plans_select.value != null
        && form.games_select.value != null
        && form.user_id.value != null
        && form.client_inicio.value != null
        && form.email.value != null ) {

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
                    testedays: form.testedays.value,
                },
            },
            success: function(data) {             
                 form.reset();
                location.reload();
            }
        }); }
        else {
            alert('Campos obrigatorios não preenchidos')
        }

    }
    function editClientJson() {

        let form = document.getElementById('client-edit-form');

        $.ajax({
            url: "{{ route('client.edit') }}",
            type: "POST",
            async: false,
            data: {
                _token: $('[name=_token]').val(),
                id_user: form.user_id.value,
                body: {
                    _token: '{{ csrf_token() }}',
                    id: form.client_id.value,
                    nome: form.nome.value,
                    email: form.email.value,
                    telefone: form.telefone.value,
                    client_inicio: form.client_inicio.value,
                    id_user: form.user_id.value,
                    id_game: form.games_select.value,
                    id_plan: form.plans_select.value,
                    testedays: form.testedays.value,

                },
            },
            success: function(data) {
                 
                form.reset();
                location.reload();
            }
        });

        }

    function showEditClient(id) {
        let form = document.getElementById('client-edit-form');

        fetch('/client/show/' + id)
            .then(response => response.json())
            .then(data => {

                form.client_id.value = id;
                form.nome.value = data.nome;
                form.email.value = data.email;
                form.telefone.value = data.telefone;
                form.client_inicio.value = data.inicio;
                form.user_id.value = data.id_user;
                form.games_select.value = data.game_id;
                form.plans_select.value = data.plano_id;

            });
    }
    function fetchUserClients(id) {

        document.getElementById('user_id').value = id;
        
        fetch('/users/clientes/' + id)
            .then(response => response.json())
            .then(data => {
                let table = document.getElementById('user-clients-table');
                table.innerHTML = '';
                var t =  $('#example').DataTable({
                        lengthMenu: [
                            [5 , 10, 25, 50,100,1000, -1],
                            [5 ,10, 25, 50, 100,1000, 'All'],
                        ],
                    
                    stateSave: true,
                    "bDestroy": true
                    });
                $('#example tbody').on( 'click', '.deletebutton', function () {
                    t 
                        .row( $(this).parents('tr') )
                        .remove()
                        .draw();
                } );

                 data.forEach(client => {
                    let row = document.createElement('tr');
                    t.row.add([`<a class="inline-block px-4 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg  focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out mr-1.5"
                        data-bs-toggle="offcanvas" href="#offcanvascliente" role="button" onClick="showEditClient(${client.id})"
                        aria-controls="clientEdit">
                            <p>Nome: ${client.nome}</p>
                            <p>Email: ${client.email}</p>
                            <p>Telefone: ${client.telefone}</p>
                            <p>Ativação:${client.data_atv}</p>
                            <p>Meio:${client.meio}</p></a>`,

                            client.name,
                            client.plano,
                            client.inicio,
                            client.termino,
                            client.status == 1 ? '<button id="button_'+client.id+'" class="bg-green-500 hover:bg-green-700  text-white font-bold py-2 px-4 rounded" onClick="desativarCliente('+client.id+')">Ativo</button>':'<button id="button_'+client.id+'"  class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onClick="ativarCliente('+client.id+')">Desativado</button>',
                            `<button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded deletebutton" onclick="deleteClient(${client.id})">
                        <svg class="w-6 h-6" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>`]).draw(false);


                });
                document.querySelector("#active").classList.add('hidden')
            });
    }


    // GAME BOTS
    function fetchGamesUser(id) {
        document.getElementById('user_id').value = id;

        fetchNoGameBots(id)
        fetch('/user/gamesuser/' + id)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                let table = document.getElementById('games-user-table');
                table.innerHTML = '';
                data.forEach(game => {
                    console.log(game);
                    let row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap dark:text-white">${game.id}</td>
                        <td class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap dark:text-white">${game.name}</td>
                        <td class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap dark:text-white">${game.url}</td>

                        <td class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap dark:text-white">
                            @can('admin')
                            <button  onClick="deleteGameUser(${game.id})" >Delete</button></td>
                            @endcan
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
            }
        });
    }
    function ativarCliente(id) {
        let id_user = +document.getElementById('user_id').value
        let btnid = '#button_'+id;
        let desative = document.querySelector(btnid);
        desative.onclick =  function () { desativarCliente(id); };  
        desative.classList.remove('bg-red-500','hover:bg-red-700');
        desative.classList.add('bg-green-500');
        desative.innerHTML = 'Ativo';
        
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
                 
            }
        });
    }
    function desativarCliente(id) {
        let id_user = +document.getElementById('user_id').value
        let btnid = '#button_'+id;
        let desative = document.querySelector(btnid);
        desative.onclick = function () { ativarCliente(id); }; 
        desative.classList.remove('bg-green-500');
        desative.classList.add('bg-red-500');
        desative.innerHTML = 'Desativado';
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
        document.getElementById('user_id').value = id;

        fetchGamesOfUsers(id)
        fetch('/user/webhooks/' + id)
            .then(response => response.json())
            .then(data => {
                console.log(data);

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

                
            }
        });
    }
</script>
