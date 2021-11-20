<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Styles -->
    <link href="{{ asset('/css/invoice.css') }}" rel="stylesheet">
</head>
<div class="container">
    <div class="card">
        <div class="card-body">
            <div id="invoice">
                <div class="invoice overflow-auto">
                    <div style="min-width: 600px">
                        <header>
                            <div class="row">
                                <div class="col">
                                    <img src="{{ asset('/images/logo.png') }}" alt="MedCongress"></a>
                                    
                                </div>
                                <div class="col company-details">
                                    <h2 class="name">
                                        <a target="_blank" href="http://medcongress.test/"> SIA Medcongress</a>
                                    </h2>
                                    <div>Liepu iela 23C, Riga, Latvia</div>
                                    <div>(+371) 289-123-45</div>
                                    <div>fin.dept@medcongress.test</div>
                                </div>
                            </div>
                        </header>
                        <main>
                            <div class="row contacts">
                                <div class="col invoice-to">
                                    <div class="text-gray-light">INVOICE TO:</div>
                                    <h2 class="to">
                                        @if($bill->users->fullNames)
                                            {{$bill->users->fullNames->name}} {{$bill->users->fullNames->surname}}
                                        @else
                                            {{$bill->users->companies->name}}
                                        @endif
                                    </h2>
                                    <div class="email"><a href="mailto:{{$bill->users->email}}">{{$bill->users->email}}</a>
                                    </div>
                                </div>
                                <div class="col invoice-details">
                                    <h1 class="invoice-id">INVOICE NO. {{$bill->id}}</h1>
                                    <div class="date">Date of Invoice: {{date('d-m-Y', strtotime($bill->created_at))}}</div>
                                    <div>IBAN: LV11UNLA0000000000001</div>
                                </div>
                            </div>
                            <table>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th class="text-left">DESCRIPTION</th>
                                        <th class="text-right">PRICE</th>
                                        <th class="text-right">QUANTITY</th>
                                        <th class="text-right">TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $counter = 1;
                                    @endphp
                                    
                                    @if($bill->total_cost_per_participation)
                                        <tr>
                                            <td class="no">{{$counter}}</td>
                                            @php
                                                $counter++;
                                            @endphp

                                            <td class="text-left">
                                                <h3>
                                                    {{$bill->events->name}}	participation		
                                                </h3>
                                                Private participant
                                            </td>
                                            
                                            <td class="unit">{{number_format($bill->total_cost_per_participation, 2, '.', ' ')}} EUR</td>
                                            <td class="qty">1</td>
                                            <td class="total">{{number_format($bill->total_cost_per_participation, 2, '.', ' ')}} EUR</td>
                                        </tr>
                                    @endif
                                        
                                    @if($bill->total_cost_per_articles)
                                        <tr>
                                            <td class="no">{{$counter}}</td>
                                            @php
                                                $counter++;
                                            @endphp

                                            <td class="text-left">
                                                <h3>
                                                    Article		
                                                </h3>
                                                Fees for article submission
                                            </td>

                                            <td class="unit">{{number_format($bill->total_cost_per_articles, 2, '.', ' ')}} EUR</td>
                                            <td class="qty">1</td>
                                            <td class="total">{{number_format($bill->total_cost_per_articles, 2, '.', ' ')}} EUR</td>
                                        </tr>
                                    @endif
                                    
                                    @if($bill->total_cost_per_materials)
                                        <tr>
                                            <td class="no">{{$counter}}</td>
                                            @php
                                                $counter++;
                                            @endphp

                                            <td class="text-left">
                                                <h3>
                                                    Materials for exhibition		
                                                </h3>
                                                Commercial participation
                                            </td>

                                            <td class="unit">{{number_format($bill->total_cost_per_materials, 2, '.', ' ')}} EUR</td>
                                            <td class="qty">1</td>
                                            <td class="total">{{number_format($bill->total_cost_per_materials, 2, '.', ' ')}} EUR</td>
                                        </tr>
                                    @endif

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td colspan="2">SUBTOTAL</td>
                                        @php
                                                $total_without_tax = ($bill->total_cost_per_articles + 
                                                                      $bill->total_cost_per_participation +
                                                                      $bill->total_cost_per_materials);
                                        @endphp
                                        <td>{{number_format($total_without_tax, 2, '.', ' ')}} EUR</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td colspan="2">VAT 21%</td>
                                        @php
                                                $tax = number_format($total_without_tax * 0.21, 2, '.', ' ');
                                        @endphp
                                        <td>{{$tax}} EUR</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td colspan="2">GRAND TOTAL</td>
                                        <td>{{number_format($total_without_tax + $tax, 2, '.', ' ') }} EUR</td>
                                    </tr>
                                </tfoot>
                            </table>
                            
                            <div class="notices">
                                <div>NOTICE:</div>
                                <div class="notice">In purpose of payment, please, indicate following information: 
                                    @if($bill->users->fullNames)
                                        {{$bill->users->fullNames->name}} {{$bill->users->fullNames->surname}},
                                    @else
                                        {{$bill->users->companies->name}},
                                    @endif
                                {{$bill->events->name}}, Invoice no. {{$bill->id}}.</div>
                            </div>
                        </main>
                        <footer>Invoice was created electronically and is valid without the signature and seal.</footer>
                    </div>
                    <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
                    <div></div>
                </div>
            </div>
        </div>
    </div>
</div>

