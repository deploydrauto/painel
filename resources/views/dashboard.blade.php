@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-12">
                <x-adminlte-profile-widget name="Bem Vindo {{ $user->name }} " class="elevation-4" layout-type="classic"
                    header-class="text-right" footer-class="bg-gradient-secondary">
                    <x-adminlte-profile-row-item style="cursor:pointer" data-toggle="modal" data-target="#modalCustom"
                        title="Clientes:" id="clientes_total" text="..." badge="info"
                        class="text-center text-white border-bottom cursor-pointer" onclick="fetchUserClients()" />
                    <x-adminlte-profile-col-item role="button" class="border-right text-white cursor-pointer" icon="fas fa-lg fa-user"
                        title="Ativos" id="clientes_ativos" text="..." size=6 badge="lime" onclick="filterUserAtivos()"/>
                    <x-adminlte-profile-col-item role="button" class="text-white" icon="fas fa-lg  fa-user-slash"
                        title="Inativos" id="clientes_inativos" text="..." size=6 badge="danger" onclick="filterUserDesativados()" />
                    <x-adminlte-profile-row-item title="Serviços" class="text-center text-white border-bottom" />
                    <x-adminlte-profile-col-item class="border-right text-white" icon="fas fa-lg fa-gamepad" title="Games"
                        id="total_games" text="..." size=6 badge="secondary" />
                    <x-adminlte-profile-col-item class="text-white cursor-pointer" icon="fas fa-lg  fa-star"
                        title="Webhooks" id="total_webhooks" text="..." size=6 badge="secondary" />
                </x-adminlte-profile-widget>




                <div class="small-box bg-cyan-300">
                    <div class="inner">
                        <h5> Ultimos Chargebacks / Devoluções</h5>
                        <ul>
                            <li>Chargeback@email.com 1</li>
                            <li>Chargeback@email.com 2</li>
                            <li>Chargeback@email.com 3</li>
                            <li>Chargeback@email.com 4</li>
                            <li>Chargeback@email.com 5</li>
                        </ul>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
                </div>
            </div>
            <div class="col-lg-9 col-12">
                <div class="card">
                    <div class="card-body">
                        {{--  create a loading  to big --}}
                        <div class="overlay dark please-wait">
                            <i class="fas fa-4x fa-sync-alt fa-spin"></i>
                        </div>

                        <canvas id="myChart"></canvas>
                    </div>
                </div>

            </div>
        </div>
        <x-adminlte-modal id="modalCustom" title="Gestão de Clientes" size="xl" theme="purple" icon="fas fa-bell"
            v-centered static-backdrop scrollable>
            {{-- add in slot header a button to add new user --}}




            <div style="height:100%;" id="div_table">
                <table id="example" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Dados</th>
                            <th>Game BOT</th>
                            <th>Plano</th>
                            <th>Inicio</th>
                            <th>termino</th>
                            <th>status</th>
                            <th>Apagar</th>
                        </tr>
                    </thead>
                    <tbody id="user-clients-table">

                    </tbody>

                </table>
            </div>
            <x-slot name="footerSlot">
                {{-- <x-adminlte-button class="mr-auto" theme="success" label="Novo Usuario" /> --}}
                <x-adminlte-button style="width: 100%" theme="success" onclick="clientModal()" label="Novo Cliente"
                    data-toggle="modal" data-target="#modalMin" />
            </x-slot>
        </x-adminlte-modal>

        {{-- Minimal --}}
        <x-adminlte-modal id="modalMin" title="Edição de Usuario" theme="purple" icon="fas fa-bolt" size='lg'>
            <form method="POST" class="client-form" name="client-form" id="client-form">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div class="form-group mb-6">
                        <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">
                        <input type="hidden" name="cliente_id" id="cliente_id" value="0">

                        <input type="text" class="form-control" id="cliente_nome" name="cliente_nome"
                            placeholder="First name">
                    </div>

                </div>
                <div class="form-group mb-6">
                    <input type="email" class="form-control " id="cliente_email" name="cliente_email"
                        placeholder="Email address">
                </div>
                <div class="form-group mb-6">
                    <input type="telefone" class="form-control " id="cliente_telefone" name="cliente_telefone"
                        placeholder="Telefone address">
                </div>
                <div class="datepicker relative form-floating form-group mb-6" data-mdb-toggle-button="false">
                    <input type="date"
                        class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                        name="client_inicio" id="client_inicio" />
                    <label for="floatingInput" class="text-gray-700">Data de Inicio</label>
                </div>
                <div class="form-group mb-6">
                    <select class="form-select " aria-label="Default select example" id="games_select"
                        name="games_select">
                        <option selected>Selecione um BOT</option>

                    </select>
                </div>

                <div class="form-group mb-6">
                    <select class=" ice-cream form-select" aria-label="Default select example" id="plans_select"
                        name="plans_select">
                        <option selected>Selecione um plano</option>

                    </select>
                </div>
                <div id="divteste" class="divteste form-group mb-6 d-none">
                    <input type="number" class="form-control  " id="testedays" name="testedays"
                        aria-describedby="testedays" placeholder="teste">
                </div>
                <div class="form-group form-check text-center mb-6">
                    <input type="checkbox"
                        class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain mr-2 cursor-pointer"
                        id="cliente_ativo" checked>
                    <label class="form-check-label inline-block text-gray-800" for="cliente_ativo">Ativo?</label>
                </div>

            </form>

            <div onclick="saveClient()" style="width: 100%" class="btn btn-primary btn-lg">Salvar</div>

        </x-adminlte-modal>

    @stop

    @section('css')
        {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    @stop
    @section('plugins.Datatables', true)
    @section('plugins.Sweetalert2', true)
    @section('js')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            $(document).ready(function() {


                const selectElement = document.querySelector('.ice-cream');

                selectElement.addEventListener('change', (event) => {

                    if (event.target.value == 5) {
                        // show plan_custom
                        console.log("selecionado")
                        document.querySelector('.divteste').classList.remove('d-none')
                    } else {
                        // hide plan_custom
                        document.querySelector('.divteste').classList.add('d-none')
                    }

                });
            });
        </script>

        <script>
            let meus_clientes = []
            let meus_games = []
            let meus_planos = []
            let meus_webhooks = []
            let total_clientes = 0
            let total_games = 0
            let total_webhooks = 0
            let total_clientes_ativos = 0
            let total_clientes_inativos = 0



            $.ajax({
                url: '/dashboard/meus_clientes/{{ $user->id }}',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    console.log(data);

                    total_games = data.users[0].games
                    document.querySelector("#total_games > div > p > span").textContent = total_games
                    total_webhooks = data.users[0].webhooks
                    document.querySelector("#total_webhooks > div > p > span").textContent = total_webhooks
                    total_clientes = data.users[0].clientes
                    document.querySelector("#clientes_total > span > span").textContent = total_clientes
                    total_clientes_ativos = data.users[0].ativos
                    document.querySelector("#clientes_ativos > div > p > span").textContent = total_clientes_ativos
                    total_clientes_inativos = data.users[0].inativos
                    document.querySelector("#clientes_inativos > div > p > span").textContent =
                        total_clientes_inativos
                    loadChart(data.graphic_label, data.grapnic_value_ative, data.grapnic_value_inative)
                    meus_games = data.games
                    // add options to select games  
                    meus_games.forEach(game => {
                        let option = document.createElement('option');
                        option.value = game.value;
                        option.text = game.label;
                        document.getElementById('games_select').appendChild(option);
                    });
                    meus_planos = data.plans
                    // add options to select planos
                    meus_planos.forEach(plano => {
                        let option = document.createElement('option');
                        option.value = plano.value;
                        option.text = plano.label;
                        document.getElementById('plans_select').appendChild(option);
                    });

                    $('.please-wait').remove();
                }
            });

            function loadChart(labels, dataset1, dataset2) {


                const ctx = document.getElementById('myChart');

                let myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [

                            {
                                label: 'Usuarios Ativos por Bot',
                                color: 'green',
                                backgroundColor: 'rgba(104,195,111,0.7)',
                                data: dataset1,
                                borderWidth: 1
                            },
                            {
                                label: 'Usuarios Inativos por Bot',
                                data: dataset2,
                                color: 'red',
                                backgroundColor: 'rgba(241,50,16,0.7)',

                                borderWidth: 1
                            }
                        ]
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

            }

            function fetchUserClients() {
                meus_clientes = [];



                $('#example').DataTable().clear().draw();
                // add row table loading spinner
                let table = document.getElementById('user-clients-table');
                let row = document.createElement('tr');
                row.innerHTML = `<td colspan="7" class="text-center">
                                    <div class="overlay dark please-wait">
                                        <i class="fas fa-4x fa-sync-alt fa-spin"></i>
                                    </div>
                                </td>`;
                table.appendChild(row);






                fetch('/users/clientes/{{ $user->id }}')
                    .then(response => response.json())
                    .then(data => {
                        console.log(data)
                        let table = document.getElementById('user-clients-table');
                        var t = $('#example').DataTable({
                            lengthMenu: [
                                [5, 10, 25, 50, 100, 1000, -1],
                                [5, 10, 25, 50, 100, 1000, 'All'],
                            ],

                            stateSave: true,
                            "bDestroy": true
                        });
                        $('#example tbody').on('click', '.deletebutton', function() {
                            t
                                .row($(this).parents('tr'))
                                .remove()
                                .draw();
                        });
                        meus_clientes = data;
                        meus_clientes.forEach((client, index) => {
                            let row = document.createElement('tr');
                            t.row.add([`<a
                            data-toggle="modal" data-target="#modalMin" onClick="clientModal(${index})"
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
                                client.status == 1 ? '<button id="button_' + client.id +
                                '"  onClick="desativarCliente(' +
                                client.id + ')">Ativo</button>' : '<button id="button_' + client.id +
                                '"   onClick="ativarCliente(' +
                                client.id + ')">Desativado</button>',
                                `<button onclick="deleteClient(${client.id})">
                <svg class="w-6 h-6" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>`
                            ]).draw(false);
                        });
                    });
            }

            function filterUserAtivos() {
                meus_clientes = [];



                $('#example').DataTable().clear().draw();
                // add row table loading spinner
                let table = document.getElementById('user-clients-table');
                let row = document.createElement('tr');
                row.innerHTML = `<td colspan="7" class="text-center">
                                    <div class="overlay dark please-wait">
                                        <i class="fas fa-4x fa-sync-alt fa-spin"></i>
                                    </div>
                                </td>`;
                table.appendChild(row);






                fetch('/users/clientes/{{ $user->id }}')

                    .then(response => response.json())
                    .then(data => {
                        console.log(data)
                        let table = document.getElementById('user-clients-table');
                        var t = $('#example').DataTable({
                            lengthMenu: [
                                [5, 10, 25, 50, 100, 1000, -1],
                                [5, 10, 25, 50, 100, 1000, 'All'],
                            ],

                            stateSave: true,
                            "bDestroy": true
                        });
                        $('#example tbody').on('click', '.deletebutton', function() {
                            t
                                .row($(this).parents('tr'))
                                .remove()
                                .draw();
                        });
                        meus_clientes = data;
                        let ativos = meus_clientes.filter(client => client.status == 1);
                        ativos.forEach((client, index) => {
                            let row = document.createElement('tr');
                            t.row.add([`<a
                            data-toggle="modal" data-target="#modalMin" onClick="clientModal(${index})"
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
                                client.status == 1 ? '<button id="button_' + client.id +
                                '"  onClick="desativarCliente(' +
                                client.id + ')">Ativo</button>' : '<button id="button_' + client.id +
                                '"   onClick="ativarCliente(' +
                                client.id + ')">Desativado</button>',
                                `<button onclick="deleteClient(${client.id})">
                <svg class="w-6 h-6" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>`
                            ]).draw(false);
                        });
                    });
                    //show modal
                    $('#modalCustom').modal('show');


                }
                // filterUserAtivos

            function filterUserDesativados() {
                meus_clientes = [];


                $('#example').DataTable().clear().draw();
                // add row table loading spinner
                let table = document.getElementById('user-clients-table');
                let row = document.createElement('tr');
                row.innerHTML = `<td colspan="7" class="text-center">
                                    <div class="overlay dark please-wait">
                                        <i class="fas fa-4x fa-sync-alt fa-spin"></i>
                                    </div>
                                </td>`;
                table.appendChild(row);


                fetch('/users/clientes/{{ $user->id }}')

                    .then(response => response.json())
                    .then(data => {
                        console.log(data)
                        let table = document.getElementById('user-clients-table');
                        var t = $('#example').DataTable({
                            lengthMenu: [
                                [5, 10, 25, 50, 100, 1000, -1],
                                [5, 10, 25, 50, 100, 1000, 'All'],
                            ],

                            stateSave: true,
                            "bDestroy": true
                        });
                        $('#example tbody').on('click', '.deletebutton', function() {
                            t
                                .row($(this).parents('tr'))
                                .remove()
                                .draw();
                        });
                        meus_clientes = data;
                        let desativados = meus_clientes.filter(client => client.status == 0);
                        desativados.forEach((client, index) => {
                            let row = document.createElement('tr');
                            t.row.add([`<a
                            data-toggle="modal" data-target="#modalMin" onClick="clientModal(${index})"
                                
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
                                client.status == 1 ? '<button id="button_' + client.id +
                                '"  onClick="desativarCliente(' +
                                client.id + ')">Ativo</button>' : '<button id="button_' + client.id +
                                '"   onClick="ativarCliente(' +
                                client.id + ')">Desativado</button>',
                                `<button onclick="deleteClient(${client.id})">
                <svg class="w-6 h-6" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>`
                            ]).draw(false);
                        });
                    });
                    //show modal
                    $('#modalCustom').modal('show');


                            
                

            }
            function clientModal(id = null) {

                if (id == null) {
                    //clear form
                    const form = document.forms.namedItem("client-form");
                    form.cliente_id.value = 0
                    form.cliente_email.value = ''
                    form.cliente_nome.value = ''
                    form.cliente_telefone.value = ''
                    form.client_inicio.value = ''
                    form.games_select.value = ''
                    form.cliente_ativo.value = ''
                    form.testedays.value = ''

                } else {
                    //fill form
                    const form = document.forms.namedItem("client-form")
                    form.cliente_id.value = meus_clientes[id].id
                    form.cliente_email.value = meus_clientes[id].email
                    form.cliente_nome.value = meus_clientes[id].nome
                    form.cliente_telefone.value = meus_clientes[id].telefone
                    form.client_inicio.value = meus_clientes[id].data_atv
                    // change game_select t selected value = 
                    let option = document.createElement('option');
                  
                    form.games_select.value = meus_clientes[id].game_id;

                    form.plans_select.value = meus_clientes[id].plano_id;

                    form.cliente_ativo.value = meus_clientes[id].ativo
                    form.testedays.value = meus_clientes[id].teste


                }
            }

            function saveClient() {

                const form = document.forms.namedItem("client-form");
                console.log(form.cliente_id.value);
                if (form.cliente_id.value == "0" || form.cliente_id.value == "" || form.cliente_id.value == null || form
                    .cliente_id.value == 0 || form.cliente_id.value == undefined) {
                    storeClientJson();
                } else {
                    editClientJson();
                }


                // const form = document.forms.namedItem("client-form")
                // console.log(form);
            }


            function storeClientJson() {

                const form = document.forms.namedItem("client-form");
                if (form.plans_select.value != null &&
                    form.games_select.value != null &&
                    form.user_id.value != null &&
                    form.client_inicio.value != null &&
                    form.cliente_email.value != null) {

                    $.ajax({
                        url: "{{ route('client.store') }}",
                        type: "POST",
                        async: false,
                        data: {
                            _token: $('[name=_token]').val(),
                            id_user: {{ $user->id }},
                            body: {
                                _token: '{{ csrf_token() }}',
                                nome: form.cliente_nome.value,
                                email: form.cliente_email.value,
                                telefone: form.cliente_telefone.value,
                                client_inicio: form.client_inicio.value,
                                id_user: {{ $user->id }},
                                id_game: form.games_select.value,
                                id_plan: form.plans_select.value,
                                testedays: form.testedays.value,
                            },
                        },
                        success: function(data) {
                            Swal.fire(
                                'Cliente Cadastrado',
                                form.cliente_nome.value,
                                'success'
                            );
                            $('#modalMin').modal('hide');
                            fetchUserClients();
                        }
                    });
                } else {
                    alert('Campos obrigatorios não preenchidos')
                }

            }

            function editClientJson() {

                let form = document.getElementById('client-form');

                $.ajax({
                    url: "{{ route('client.edit') }}",
                    type: "POST",
                    async: false,
                    data: {
                        _token: $('[name=_token]').val(),
                        id_user: {{ $user->id }},
                        body: {
                            _token: '{{ csrf_token() }}',
                            id: form.cliente_id.value,
                            nome: form.cliente_nome.value,
                            email: form.cliente_email.value,
                            telefone: form.cliente_telefone.value,
                            client_inicio: form.client_inicio.value,
                            id_user: {{ $user->id }},
                            id_game: form.games_select.value,
                            id_plan: form.plans_select.value,
                            testedays: form.testedays.value,

                        },
                    },
                    success: function(data) {
                        Swal.fire(
                            'Cliente Editado',
                            form.cliente_nome.value,
                            'success'
                        );
                        $('#modalMin').modal('hide');
                        // edit datatable falue of client
                        fetchUserClients();
                    }
                });
            }


            function ativarCliente(id) {
                let id_user = +document.getElementById('user_id').value
                let btnid = '#button_' + id;
                let desative = document.querySelector(btnid);
                desative.onclick = function() {
                    desativarCliente(id);
                };
                desative.classList.remove('bg-red-500', 'hover:bg-red-700');
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
                let btnid = '#button_' + id;
                let desative = document.querySelector(btnid);
                desative.onclick = function() {
                    ativarCliente(id);
                };
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
        </script>
    @stop
