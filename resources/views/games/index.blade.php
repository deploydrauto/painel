<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        {{-- align x-primary-button  from right --}}
        <div class="flex justify-end">
            <x-primary-button class="mt-4" onclick="showModal('games-create')">{{ __('Adicionar') }}
            </x-primary-button>
        </div>
        {{-- <form method="POST" action="{{ route('games.store') }}">
            @csrf
            <textarea
                name="message"
                placeholder="{{ __('What\'s on your mind?') }}"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >{{ old('message') }}</textarea>
            <x-input-error :messages="$errors->get('message')" class="mt-2" />
            <x-primary-button class="mt-4">{{ __('Games') }}</x-primary-button>
        </form> --}}
        <x-bladewind.table striped="true" divider="thin">

            <x-slot name="header">
                <th>BOTGAME</th>
                <th>Status</th>
                <th>Estatisticas</th>
                <th>Actions</th>
            </x-slot>
            @foreach ($games as $game)
            <tr>
                <td>{{ $game->name}}</td>
                <td>{{ $game->status == 1 ? 'Ativo': 'Desativado'}}</td>
                <td><p>Admins :  {{$game->admins}}</p>
                    <p>Clientes : {{$game->clientes}}</p></td>
                <td>xx</td>
            </tr>
            @endforeach
        </x-bladewind.table>
    </div>


    <x-bladewind.modal
     name="games-create"
     title="Cadastrar Novo GAME BOT"
     size="big" id=""
     ok_button_text=""
     >
     <form method="POST" action="{{ route('games.store') }}" >
        @csrf

            <input type="text" name="name" placeholder="game">

            <x-bladewind.checkbox name="active" label="I am checked by default" checked="true" />

            <x-primary-button  type='submit' class="mt-4">{{ __('Salvar') }}</x-primary-button>
        </form>
    </x-bladewind.modal>


</x-app-layout>

<script>
    //send modal data do store
</script>
