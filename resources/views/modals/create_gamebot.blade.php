<div class="modal m-auto  max-w-md fade fixed top-5 inset-0 hidden w-full  outline-none overflow-x-hidden overflow-y-auto"
            id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog relative w-auto pointer-events-none">
                <div
                    class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
                    <div
                        class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                        <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalLabel">
                           Cadastro de GAME BOT
                        </h5>
                        <button type="button"
                            class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
                            data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="{{ route('games.store') }}">
                        <div class="modal-body relative p-4">

                            @csrf

                            <input type="text" name="name" placeholder="game">
                            <br>
                            <x-bladewind.checkbox name="active" label="Ativo ?" checked="true" />

                            {{-- <x-primary-button  type='submit' class="mt-4">{{ __('Salvar') }}</x-primary-button> --}}

                        </div>
                        <div
                            class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md">
                            <x-secondary-button type="button" class="mt-4"  data-bs-dismiss="modal">Close</x-secondary-button>
                            <x-primary-button  type='submit' class="mt-4">{{ __('Salvar') }}</x-primary-button>

                            {{-- <button type="button" type='submit'
                                class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out ml-1">{{ __('Salvar') }}</button> --}}
                    </form>
                </div>
            </div>
        </div>
    </div>
