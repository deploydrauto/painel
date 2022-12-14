<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        {{-- align x-primary-button  from right --}}
        <div class="flex justify-end">
            <x-primary-button class="mt-4" onclick="showModal('games-create')">{{ __('Adicionar') }}
            </x-primary-button>
        </div>

        {{-- <x-bladewind.table striped="true" divider="thin">

            <x-slot name="header">
                <th>Cliente</th>
                <th>email</th>
                <th>status</th>
                <th>Actions</th>
            </x-slot>
            @foreach ($clientes as $cliente)
            <tr>
                <td>{{ $cliente->name}}</td>
                <td>{{ $cliente->status == 1 ? 'Ativo': 'Desativado'}}</td>
                <td><p>Admins :  {{$cliente->admins}}</p>
                    <p>Clientes : {{$cliente->clientes}}</p></td>
                <td>xx</td>
            </tr>
            @endforeach
        </x-bladewind.table> --}}
    </div>

{{--
    <x-bladewind.modal
     name="games-create"
     title="Cadastrar Novo GAME BOT"
     size="big" id=""
     ok_button_text=""
     >
     <form method="POST" action="{{ route('games.store') }}" >
        @csrf

            <input type="text" name="name" placeholder="game">

            {{-- <x-bladewind.checkbox name="active" label="I am checked by default" checked="true" /> --}}

            {{-- <x-primary-button  type='submit' class="mt-4">{{ __('Salvar') }}</x-primary-button>
        </form>
    </x-bladewind.modal> --}} --}}


</x-app-layout>

<script>
    //send modal data do store
</script>
