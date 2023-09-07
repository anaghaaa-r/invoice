<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Invoices') }}
        </h2>

    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <form id="invoice-form" action="{{ route('invoice.save') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="grid gap-6 mb-6 md:grid-cols-2">

                            <div>
                                <label for="quantity" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Quantity</label>
                                <input type="text" name="quantity" id="quantity" oninput="calculateAmount()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Enter quantity here" required>
                                <p id="quantity-validate" class="mt-2 text-sm text-gray-500"></p>
                            </div>

                            <div>
                                <label for="amount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Amount</label>
                                <input type="text" name="amount" id="amount" oninput="calculateAmount()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Enter amount here" required>
                                <p id="amount-validate" class="mt-2 text-sm text-gray-500"></p>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="total_amount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Total Amount</label>
                            <input type="text" name="total_amount" id="total_amount" oninput="calculateAmount()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" readonly disabled>
                        </div>

                        <div class="mb-6">
                            <label for="tax_percentage" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Tax Percentage</label>
                            <select name="tax_percentage" id="tax_percentage" oninput="calculateAmount()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected value="0">0%</option>
                                <option value="5">5%</option>
                                <option value="12">12%</option>
                                <option value="18">18%</option>
                                <option value="28">28%</option>
                            </select>
                        </div>

                        <div class="grid gap-6 mb-6 md:grid-cols-2">

                            <div>
                                <label for="tax_amount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tax Amount</label>
                                <input type="text" name="tax_amount" id="tax_amount" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" readonly disabled>
                            </div>

                            <div>
                                <label for="net_amount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Net Amount</label>
                                <input type="text" name="net_amount" id="net_amount" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" readonly disabled>
                            </div>

                        </div>

                        <div class="mb-6">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Customer Name</label>
                            <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Enter customer name here" required>
                            <p id="customer-name-validate" class="mt-2 text-sm text-gray-500"></p>
                        </div>

                        <div class="mb-6">
                            <label for="invoice_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Invoice Date</label>
                            <input type="text" name="invoice_date" id="invoice_date" placeholder="yyyy-mm-dd" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            <p id="invoice-date-validate" class="mt-2 text-sm text-gray-500"></p>
                        </div>

                        <div class="mb-6">
                            <label for="file" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Upload file</label>
                            <input type="file" name="file" id="file" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
                            <p id="file-validate" class="mt-2 text-sm text-gray-500"></p>
                        </div>

                        <div class="mb-6">
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email address</label>
                            <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="john.doe@example.com" required>
                            <p id="customer-email-validate" class="mt-2 text-sm text-gray-500"></p>
                        </div>

                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Create Invoice
                        </button>
                        <p id="submit-message" class="mt-2 text-sm text-gray-500"></p>
                    </form>

                </div>
            </div>
        </div>
    </div>


    <!-- Scripts -->
    <script src="{{ asset('js/custom-invoice.js') }}"></script>
    <script>
        function calculateAmount() {
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