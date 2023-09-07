<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Invoices') }}
        </h2>

    </x-slot>

    <div class="py-12">
        <div class="mx-auto sm:px-2 lg:px-4">

            <div class="flex flex-col">

                <div class="-m-1.5 overflow-x-auto">
                    <div class="min-w-full inline-block align-middle">
                        <div class="overflow-hidden">

                            <table class="min-w-full text-sm text-left text-gray-500 dark:text-gray-400">

                                <thead class="text-xs text-gray-900 uppercase dark:text-gray-400">

                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Customer Name
                                        </th>

                                        <th scope="col" class="px-6 py-3">
                                            Quantity
                                        </th>

                                        <th scope="col" class="px-6 py-3">
                                            Amount
                                        </th>

                                        <th scope="col" class="px-6 py-3">
                                            Total Amount
                                        </th>

                                        <th scope="col" class="px-6 py-3">
                                            Tax Percentage
                                        </th>

                                        <th scope="col" class="px-6 py-3">
                                            Tax Amount
                                        </th>

                                        <th scope="col" class="px-6 py-3">
                                            Net Amount
                                        </th>

                                        <th scope="col" class="px-6 py-3">
                                            Invoice Date
                                        </th>

                                        <th scope="col" class="px-6 py-3">
                                            Uploaded File
                                        </th>

                                        <th scope="col" class="px-6 py-3">
                                            Customer Email
                                        </th>

                                        <th scope="col" class="px-6 py-3">
                                            Actions
                                        </th>
                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach ($invoices as $invoice)
                                    <tr class="bg-white dark:bg-gray-800">

                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $invoice->name }}
                                        </th>

                                        <td class="px-6 py-4">
                                            {{ $invoice->quantity }}
                                        </td>

                                        <td class="px-6 py-4">
                                            {{ $invoice->amount }}
                                        </td>

                                        <td class="px-6 py-4">
                                            {{ $invoice->total_amount }}
                                        </td>

                                        <td class="px-6 py-4">
                                            {{ $invoice->tax_percentage }}%
                                        </td>

                                        <td class="px-6 py-4">
                                            {{ $invoice->tax_amount }}
                                        </td>

                                        <td class="px-6 py-4">
                                            {{ $invoice->net_amount }}
                                        </td>

                                        <td class="px-6 py-4">
                                            {{ $invoice->invoice_date }}
                                        </td>

                                        <td class="px-6 py-4">
                                            @if (pathinfo($invoice->file, PATHINFO_EXTENSION) === 'pdf')
                                            <iframe src="{{ asset('storage/' . $invoice->file) }}" width="150px"></iframe>
                                            <a href="{{ asset('storage/' . $invoice->file) }}" target="_blank" class="mt-3 flex items-center justify-center px-3 py-2 space-x-2 text-sm tracking-wide text-white capitalize transition-colors duration-200 transform bg-indigo-500 rounded-md dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:bg-indigo-700 hover:bg-indigo-600 focus:outline-none focus:bg-indigo-500 focus:ring focus:ring-indigo-300 focus:ring-opacity-50">
                                                Open File
                                            </a>
                                            <a href="{{ asset('storage/' . $invoice->file) }}" target="_blank" download class="mt-3 flex items-center justify-center px-3 py-2 space-x-2 text-sm tracking-wide text-white capitalize transition-colors duration-200 transform bg-indigo-500 rounded-md dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:bg-indigo-700 hover:bg-indigo-600 focus:outline-none focus:bg-indigo-500 focus:ring focus:ring-indigo-300 focus:ring-opacity-50">
                                                Download File
                                            </a>
                                            @else
                                            <img src="{{ asset('storage/' . $invoice->file) }}" width="150px" alt="Invoice File">
                                            <a href="{{ asset('storage/' . $invoice->file) }}" target="_blank" class="mt-3 flex items-center justify-center px-3 py-2 space-x-2 text-sm tracking-wide text-white capitalize transition-colors duration-200 transform bg-indigo-500 rounded-md dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:bg-indigo-700 hover:bg-indigo-600 focus:outline-none focus:bg-indigo-500 focus:ring focus:ring-indigo-300 focus:ring-opacity-50">
                                                Open File
                                            </a>
                                            <a href="{{ asset('storage/' . $invoice->file) }}" target="_blank" download class="mt-3 flex items-center justify-center px-3 py-2 space-x-2 text-sm tracking-wide text-white capitalize transition-colors duration-200 transform bg-indigo-500 rounded-md dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:bg-indigo-700 hover:bg-indigo-600 focus:outline-none focus:bg-indigo-500 focus:ring focus:ring-indigo-300 focus:ring-opacity-50">
                                                Download File
                                            </a>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4">
                                            {{ $invoice->email }}
                                        </td>

                                        <td class="px-6 py-4">

                                            <!-- edit invoice modal -->
                                            <div x-data="{ modelOpen: false }">
                                                <button @click="modelOpen = !modelOpen" class="flex items-center justify-center px-3 py-2 space-x-2 text-sm tracking-wide text-white capitalize transition-colors duration-200 transform bg-indigo-500 rounded-md dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:bg-indigo-700 hover:bg-indigo-600 focus:outline-none focus:bg-indigo-500 focus:ring focus:ring-indigo-300 focus:ring-opacity-50">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                                    </svg>
                                                    <span>Edit</span>
                                                </button>

                                                <div x-show="modelOpen" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="edit-modal-title-{{ $invoice->id }}" role="dialog" aria-modal="true">
                                                    <div class="flex items-end justify-center min-h-screen px-4 text-center md:items-center sm:block sm:p-0">
                                                        <div x-cloak @click="modelOpen = false" x-show="modelOpen" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-40" aria-hidden="true"></div>

                                                        <div x-cloak x-show="modelOpen" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block w-full max-w-xl p-8 my-20 overflow-hidden text-left transition-all transform bg-white dark:bg-gray-800 rounded-lg shadow-xl 2xl:max-w-2xl">
                                                            <div class="flex items-center justify-between space-x-4">
                                                                <h1 class="text-xl font-medium text-gray-800 dark:text-gray-200">Edit Invoice</h1>

                                                                <button @click="modelOpen = false" class="text-gray-600 focus:outline-none hover:text-gray-700">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                    </svg>
                                                                </button>
                                                            </div>

                                                            <p class="mt-2 text-sm text-gray-500">
                                                                Edit the selected invoice.
                                                            </p>

                                                            <form class="mt-5" id="invoice-edit-form" action="{{ route('invoice.edit', [ 'id' =>$invoice->id ]) }}" method="post" enctype="multipart/form-data">
                                                                @csrf
                                                                <!-- customer name -->
                                                                <div>
                                                                    <label for="name" class="block text-sm text-gray-700 capitalize dark:text-gray-400">Customer name</label>
                                                                    <input name="name" id="name" value="{{ $invoice->name }}" type="text" class="block w-full px-3 py-2 mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg placeholder-gray-400 focus:outline-none focus:ring focus:ring-blue-500 focus:ring-opacity-40 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                                    <p id="customer-name-validate" class="mt-2 text-sm text-gray-500"></p>
                                                                </div>

                                                                <!-- quantity -->
                                                                <div class="mt-4">
                                                                    <label for="quantity" class="block text-sm text-gray-700 capitalize dark:text-gray-400">Quantity</label>
                                                                    <input oninput="calculateValues()" name="quantity" id="quantity" value="{{ $invoice->quantity }}" type="text" class="block w-full px-3 py-2 mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg placeholder-gray-400 focus:outline-none focus:ring focus:ring-blue-500 focus:ring-opacity-40 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                                    <p id="quantity-validate" class="mt-2 text-sm text-gray-500"></p>
                                                                </div>

                                                                <!-- amount -->
                                                                <div class="mt-4">
                                                                    <label for="amount" class="block text-sm text-gray-700 capitalize dark:text-gray-400">Amount</label>
                                                                    <input oninput="calculateValues()" name="amount" id="amount" value="{{ $invoice->amount }}" type="text" class="block w-full px-3 py-2 mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg placeholder-gray-400 focus:outline-none focus:ring focus:ring-blue-500 focus:ring-opacity-40 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                                    <p id="amount-validate" class="mt-2 text-sm text-gray-500"></p>
                                                                </div>

                                                                <!-- total amount -->
                                                                <div class="mt-4">
                                                                    <label for="total_amount" class="block text-sm text-gray-700 capitalize dark:text-gray-400">Total Amount</label>
                                                                    <input oninput="calculateValues()" name="total_amount" id="total_amount" readonly disabled value="{{ $invoice->total_amount }}" type="email" class="block w-full px-3 py-2 mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg placeholder-gray-400 focus:outline-none focus:ring focus:ring-blue-500 focus:ring-opacity-40 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                                </div>

                                                                <!-- tax percentage -->
                                                                <div class="mt-4">
                                                                    <label for="tax_percentage" class="block text-sm text-gray-700 capitalize dark:text-gray-400">Select Tax Percentage</label>
                                                                    <select oninput="calculateValues()" name="tax_percentage" id="tax_percentage" oninput="calculateAmount()" class="block w-full px-3 py-2 mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg placeholder-gray-400 focus:outline-none focus:ring focus:ring-blue-500 focus:ring-opacity-40 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                                        <option selected value="{{ $invoice->tax_percentage }}">{{ $invoice->tax_percentage }}%</option>
                                                                        @if ($invoice->tax_percentage !== '0')
                                                                        <option value="0">0%</option>
                                                                        @endif
                                                                        @if ($invoice->tax_percentage !== '5')
                                                                        <option value="5">5%</option>
                                                                        @endif
                                                                        @if ($invoice->tax_percentage !== '12')
                                                                        <option value="12">12%</option>
                                                                        @endif
                                                                        @if ($invoice->tax_percentage !== '18')
                                                                        <option value="18">18%</option>
                                                                        @endif
                                                                        @if ($invoice->tax_percentage !== '28')
                                                                        <option value="28">28%</option>
                                                                        @endif
                                                                    </select>
                                                                </div>

                                                                <!-- tax amount -->
                                                                <div class="mt-4">
                                                                    <label for="tax_amount" class="block text-sm text-gray-700 capitalize dark:text-gray-400">Tax Amount</label>
                                                                    <input name="tax_amount" id="tax_amount" readonly value="{{ $invoice->tax_amount }}" type="email" class="block w-full px-3 py-2 mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg placeholder-gray-400 focus:outline-none focus:ring focus:ring-blue-500 focus:ring-opacity-40 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                                </div>

                                                                <!-- net amount -->
                                                                <div class="mt-4">
                                                                    <label for="net_amount" class="block text-sm text-gray-700 capitalize dark:text-gray-400">Net Amount</label>
                                                                    <input name="net_amount" id="net_amount" readonly value="{{ $invoice->net_amount }}" type="email" class="block w-full px-3 py-2 mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg placeholder-gray-400 focus:outline-none focus:ring focus:ring-blue-500 focus:ring-opacity-40 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                                </div>

                                                                <!-- invoice date -->
                                                                <div class="mt-4">
                                                                    <label for="invoice_date" class="block text-sm text-gray-700 capitalize dark:text-gray-400">Invoice Date</label>
                                                                    <input type="text" name="invoice_date" id="invoice_date" value="{{ $invoice->invoice_date }}" class="block w-full px-3 py-2 mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg placeholder-gray-400 focus:outline-none focus:ring focus:ring-blue-500 focus:ring-opacity-40 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                                </div>

                                                                <!-- file -->
                                                                <div class="mt-4">
                                                                    <label for="file" class="block text-sm text-gray-700 capitalize dark:text-gray-400">File</label>
                                                                    <input type="file" name="file" id="file" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
                                                                </div>

                                                                <!-- customer email -->
                                                                <div class="mt-4">
                                                                    <label for="email" class="block text-sm text-gray-700 capitalize dark:text-gray-400">Customer Email</label>
                                                                    <input name="email" id="email" value="{{ $invoice->email }}" type="email" class="block w-full px-3 py-2 mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg placeholder-gray-400 focus:outline-none focus:ring focus:ring-blue-500 focus:ring-opacity-40 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                                    <p id="customer-email-validate" class="mt-2 text-sm text-gray-500"></p>
                                                                </div>

                                                                <!-- submit button -->
                                                                <div class="flex justify-end mt-6">
                                                                    <button type="submit" class="px-3 py-2 text-sm tracking-wide text-white capitalize transition-colors duration-200 transform bg-indigo-500 rounded-md dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:bg-indigo-700 hover:bg-indigo-600 focus:outline-none focus:bg-indigo-500 focus:ring focus:ring-indigo-300 focus:ring-opacity-50">
                                                                        Save Invoice
                                                                    </button>
                                                                </div>
                                                                <p id="submit-message" class="mt-2 text-sm text-gray-500"></p>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- delete invoice modal -->
                                            <div x-data="{ modelOpen: false }" class="mt-4">
                                                <button @click="modelOpen = !modelOpen" class="flex items-center justify-center px-3 py-2 space-x-2 text-sm tracking-wide text-white capitalize transition-colors duration-200 transform bg-indigo-500 rounded-md dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:bg-indigo-700 hover:bg-indigo-600 focus:outline-none focus:bg-indigo-500 focus:ring focus:ring-indigo-300 focus:ring-opacity-50">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                    </svg>

                                                    <span>Remove</span>
                                                </button>

                                                <div x-show="modelOpen" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="delete-modal-title-{{ $invoice->id }}" role="dialog" aria-modal="true">
                                                    <div class="flex items-end justify-center min-h-screen px-4 text-center md:items-center sm:block sm:p-0">
                                                        <div x-cloak @click="modelOpen = false" x-show="modelOpen" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-40" aria-hidden="true"></div>

                                                        <div x-cloak x-show="modelOpen" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block w-full max-w-xl p-8 my-20 overflow-hidden text-left transition-all transform bg-white dark:bg-gray-800 rounded-lg shadow-xl 2xl:max-w-2xl">
                                                            <div class="flex items-center justify-between space-x-4">
                                                                <h1 class="text-xl font-medium text-gray-800 dark:text-gray-200">Delete Invoice</h1>

                                                                <button @click="modelOpen = false" class="text-gray-600 focus:outline-none hover:text-gray-700">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                    </svg>
                                                                </button>
                                                            </div>

                                                            <form class="mt-5" id="invoice-delete-form" action="{{ route('invoice.delete', [ 'id' =>$invoice->id ]) }}" method="post">
                                                                @csrf
                                                                @method('DELETE')

                                                                <div>
                                                                    Are you sure you want to delete this invoice ?
                                                                    <br>
                                                                    Customer Name: {{ $invoice->name }}
                                                                </div>

                                                                <div class="flex justify-end mt-6">
                                                                    <!-- cancel button -->
                                                                    <a @click="modelOpen = false" class="mr-4 px-3 py-2 text-sm tracking-wide text-white capitalize transition-colors duration-200 transform bg-gray-500 rounded-md dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:bg-gray-700 hover:bg-gray-600 focus:outline-none focus:bg-gray-500 focus:ring focus:ring-gray-300 focus:ring-opacity-50" style="cursor: pointer;">
                                                                        Cancel
                                                                    </a>

                                                                    <!-- submit button -->
                                                                    <button type="submit" class="px-3 py-2 text-sm tracking-wide text-white capitalize transition-colors duration-200 transform bg-red-500 rounded-md dark:bg-red-600 dark:hover:bg-red-700 dark:focus:bg-red-700 hover:bg-red-600 focus:outline-none focus:bg-red-500 focus:ring focus:ring-red-300 focus:ring-opacity-50">
                                                                        Delete Invoice
                                                                    </button>
                                                                </div>
                                                                <p id="delete-message" class="mt-2 text-sm text-gray-500"></p>

                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

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
    </div>

    <script src="{{ asset('js/custom-change.js') }}"></script>
    <script>
        function calculateValues(O) {
            var quantity = document.getElementById('quantity').value || 0;
            var amount = document.getElementById('amount').value || 0;

            var totalAmount = quantity * amount;
            document.getElementById('total_amount').value = totalAmount;

            var taxPercentage = document.getElementById('tax_percentage').value || 0;

            var taxAmount = (totalAmount * taxPercentage) / 100;
            document.getElementById('tax_amount').value = taxAmount;

            var netAmount = totalAmount + taxAmount;
            document.getElementById('net_amount').value = netAmount;
        }
    </script>

    <!-- date picker -->
    <script>
        $(document).ready(function() {
            $("#invoice_date").datepicker({
                dateFormat: 'yy-mm-dd',
            });
        });
    </script>
</x-app-layout>