<?php

namespace App\Http\Controllers;

class RoutesDefinition
{

    public function salesTrendAnalysisRoutes()
    {
        return

            [
                // 1 => Zones
                'Zone' => [
                    'name' =>  'zone',
                    'class_path' => 'Analysis\SalesGathering\ZoneAgainstAnalysisReport',
                    'analysis_view' => 'ZoneSalesAnalysisIndex',
                    'analysis_result' => 'ZoneSalesAnalysisResult',
                    'against_view'  => 'index',
                    'against_result'  => 'result',
                    'discount_result'  => 'resultForSalesDiscount',
                    'sub_items' => [
                        'SalesChannels' => 'salesChannels',
                        'Customers' => 'customers',
                        'Categories' => 'categories',
                        'Products' => 'products',
                        'Principles' => 'principles',
                        'ProductsItems' => 'Items',
                        'SalesPersons' => 'salesPersons',
                        'BusinessSectors' => 'businessSectors',
                        'Branches' => 'branches',
                        'SalesDiscount' => 'salesDiscount',
                    ],
                    'avg_items' => [
                        'Products' => 'products',
                        'ProductsItems' => 'Items',
                    ],
                    'has_discount' => true,
                    'has_break_down' => true,
                ],
                // 2 => Sales Channels
                'SalesChannels' => [
                    'name' =>  'salesChannels',
                    'class_path' => 'Analysis\SalesGathering\SalesChannelsAgainstAnalysisReport',
                    'analysis_view' => 'SalesChannelsSalesAnalysisIndex',
                    'analysis_result' => 'SalesChannelsSalesAnalysisResult',
                    'against_view'  => 'index',
                    'against_result'  => 'result',
                    'discount_result'  => 'resultForSalesDiscount',
                    'sub_items' => [
                        'Zones' => 'zones',
                        'Customers' => 'customers',
                        'Categories' => 'categories',
                        'Products' => 'products',
                        'Principles' => 'principles',
                        'ProductsItems' => 'Items',
                        'SalesPersons' => 'salesPersons',
                        'BusinessSectors' => 'businessSectors',
                        'Branches' => 'branches',
                        'SalesDiscount' => 'salesDiscount',
                    ],
                    'avg_items' => [
                        'Products' => 'products',
                        'ProductsItems' => 'Items',
                    ],
                    'has_discount' => true,
                    'has_break_down' => true,
                ],
                // 3 => Categories
                'Categories' => [
                    'name' =>  'categories',
                    'class_path' => 'Analysis\SalesGathering\CategoriesAgainstAnalysisReport',
                    'analysis_view' => 'CategoriesSalesAnalysisIndex',
                    'analysis_result' => 'CategoriesSalesAnalysisResult',
                    'against_view'  => 'index',
                    'against_result'  => 'result',
                    'discount_result'  => 'resultForSalesDiscount',
                    'sub_items' => [
                        'Zones' => 'zones',
                        'Customers' => 'customers',
                        'SalesChannels' => 'salesChannels',
                        'Products' => 'products',
                        'ProductsItems' => 'Items',
                        'SalesPersons' => 'salesPersons',
                        'BusinessSectors' => 'businessSectors',
                        'Branches' => 'branches',
                        'SalesDiscount' => 'salesDiscount',
                    ],
                    'avg_items' => [
                        'Products' => 'products'
                    ],
                    'has_discount' => true,
                    'has_break_down' => true,
                ],
                // 4 => Products
                'Products' => [
                    'name' =>  'products',
                    'class_path' => 'Analysis\SalesGathering\ProductsAgainstAnalysisReport',
                    'against_view'  => 'index',
                    'against_result'  => 'result',
                    'discount_result'  => 'resultForSalesDiscount',
                    'sub_items' => [
                        'Zones' => 'zones',
                        'SalesChannels' => 'salesChannels',
                        'ProductsItems' => 'Items',
                        'SalesPersons' => 'salesPersons',
                        'BusinessSectors' => 'businessSectors',
                        'Branches' => 'branches',
                        'SalesDiscount' => 'salesDiscount',
                    ],
                    'avg_items' => [
                        'ProductsItems' => 'Items',
                    ],
                    'has_discount' => true,
                    'has_break_down' => true,
                ],
                // 5 => Product Items
                'ProductItems' => [
                    'name' =>  'Items',
                    'class_path' => 'Analysis\SalesGathering\SKUsAgainstAnalysisReport',
                    'against_view'  => 'index',
                    'against_result'  => 'result',
                    'discount_result'  => 'resultForSalesDiscount',
                    'sub_items' => [
                        'Zones' => 'zones',
                        'SalesChannels' => 'salesChannels',
                        'SalesPersons' => 'salesPersons',
                        'BusinessSectors' => 'businessSectors',
                        'Branches' => 'branches',
                        'SalesDiscount' => 'salesDiscount',
                        
                    ],
                    'has_discount' => true,
                    'has_break_down' => true,
                ],
                // 6 => Branches
                'Branches' => [
                    'name' =>  'branches',
                    'class_path' => 'Analysis\SalesGathering\BranchesAgainstAnalysisReport',
                    'analysis_view' => 'BranchesSalesAnalysisIndex',
                    'analysis_result' => 'BranchesSalesAnalysisResult',
                    'against_view'  => 'index',
                    'against_result'  => 'result',
                    'discount_result'  => 'resultForSalesDiscount',
                    'sub_items' => [
                        'zones' => 'zones',
                        'SalesChannels' => 'salesChannels',
                        'Customers' => 'customers',
                        'Categories' => 'categories',
                        'Products' => 'products',
                        'Principles' => 'principles',
                        'ProductsItems' => 'Items',
                        'SalesPersons' => 'salesPersons',
                        'BusinessSectors' => 'businessSectors',
                        'SalesDiscount' => 'salesDiscount',
                    ],
                    'has_discount' => true,
                    'has_break_down' => true,
                ],
                // 7 => Business Sectors
                'BusinessSectors' => [
                    'name' =>  'businessSectors',
                    'class_path' => 'Analysis\SalesGathering\BusinessSectorsAgainstAnalysisReport',
                    'analysis_view' => 'BusinessSectorsSalesAnalysisIndex',
                    'analysis_result' => 'BusinessSectorsSalesAnalysisResult',
                    'against_view'  => 'index',
                    'against_result'  => 'result',
                    'discount_result'  => 'resultForSalesDiscount',
                    'sub_items' => [
                        'zones' => 'zones',
                        'SalesChannels' => 'salesChannels',
                        'Customers' => 'customers',
                        'Categories' => 'categories',
                        'Products' => 'products',
                        'Principles' => 'principles',
                        'ProductsItems' => 'Items',
                        'SalesPersons' => 'salesPersons',
                        'Branches' => 'branches',
                        'SalesDiscount' => 'salesDiscount',
                    ],
                    'avg_items' => [
                        'Products' => 'products',
                        'ProductsItems' => 'Items',
                    ],
                    'has_discount' => true,
                    'has_break_down' => true,
                ],
                // 8 => Sales Persons
                'SalesPersons' => [
                    'name' =>  'salesPersons',
                    'class_path' => 'Analysis\SalesGathering\SalesPersonsAgainstAnalysisReport',
                    'against_view'  => 'index',
                    'against_result'  => 'result',
                    'discount_result'  => 'resultForSalesDiscount',
                    'sub_items' => [
                        'Zones' => 'zones',
                        'SalesChannels' => 'salesChannels',
                        'Categories' => 'categories',
                        'Principles' => 'principles',
                        'Products' => 'products',
                        'ProductItems' => 'Items',
                        'BusinessSectors' => 'businessSectors',
                        'Branches' => 'branches',
                        'SalesDiscount' => 'salesDiscount',
                    ],
                    'has_discount' => true,
                    'has_break_down' => true,
                ],
                // 9 => Principles
                'Principles' => [
                    'name' =>  'principles',
                    'has_discount' => true,
                    'has_break_down' => true,
                ],
                // 10 => Customers
                'Customers' => [
                    'name' =>  'customers',
                    'has_discount' => true,
                    'has_break_down' => true,
                ],
                // 11=> ServiceProvider
                'ServiceProvider' => [
                    'name' =>  'serviceProvider',
                    'has_discount' => false,
                    'has_break_down' => true,
                ],
                // 12 => ServiceProviderTyp
                'ServiceProviderTyp' => [
                    'name' =>  'serviceProviderType',
                    'has_discount' => false,
                    'has_break_down' => true,
                ],
                // 12 => ServiceProviderAge
                'ServiceProviderAge' => [
                    'name' =>  'serviceProviderAge',
                    'has_discount' => false,
                    'has_break_down' => true,
                ],
                // 13 => Sales DiscountS
                'SalesDiscountS' => [
                    'name' =>  'salesDiscounts',
                    'has_discount' => false,
                    'has_break_down' => true,
                ],
                // 14 => Countries
                'Countries' => [
                    'name' =>  'country',
                    'class_path' => 'Analysis\SalesGathering\CountriesAgainstAnalysisReport',
                    'analysis_view' => 'CountriesSalesAnalysisIndex',
                    'analysis_result' => 'CountriesSalesAnalysisResult',
                    'against_view'  => 'index',
                    'against_result'  => 'result',
                    'discount_result'  => 'resultForSalesDiscount',
                    'sub_items' => [
                        'Zones' => 'zones',
                        'SalesChannels' => 'salesChannels',
                        'Customers' => 'customers',
                        'Categories' => 'categories',
                        'Products' => 'products',
                        'Principles' => 'principles',
                        'ProductsItems' => 'Items',
                        'SalesPersons' => 'salesPersons',
                        'BusinessSectors' => 'businessSectors',
                        'Branches' => 'branches',
                        'SalesDiscount' => 'salesDiscount',
                    ],
                    'avg_items' => [
                        'Products' => 'products',
                        'ProductsItems' => 'Items',
                    ],
                    'has_discount' => true,
                    'has_break_down' => true,
                ],

            ];
    }
    public function  twoDimensionalBreakdownRoutes()
    {
        return [
            // 1 => Zones
            'Zones' => [
                'name' =>  'zone',
                'is_provider' => false,
                'sub_items' => [
                    'SalesChannels' => 'salesChannels',
                ]
            ],
            // 1 => businessSectors
            'BusinessSectors' => [
                'name' =>  'businessSectors',
                'is_provider' => false,
                'sub_items' => [
                    'SalesChannels' => 'salesChannels',
                ]
            ],
            // 2 => Sales Channels
            'SalesChannels' => [
                'name' =>  'salesChannels',
                'is_provider' => false,
                'sub_items' => [
                    'Zones' => 'zones',
                ]
            ],
            // 3 => Products
            'Products' => [
                'name' =>  'products',
                'is_provider' => false,
                'sub_items' => [
                    'Zones' => 'zones',
                    'SalesChannels' => 'salesChannels',
                    'BusinessSectors' => 'businessSectors',
                'branches' => 'branches',
                ]
            ],
            // 4 => ProductItems
            'ProductItems' => [
                'name' =>  'Items',
                'is_provider' => false,
                'sub_items' => [
                    'Zones' => 'zones',
                    'SalesChannels' => 'salesChannels',
                    'BusinessSectors' => 'businessSectors',
                    'Branches'=>'branches'
                ]
            ],
            // 5 => Categories
            'Categories' => [
                'name' =>  'categories',
                'is_provider' => false,
                'sub_items' => [
                    'Zones' => 'zones',
                    'SalesChannels' => 'salesChannels',
                    'BusinessSectors' => 'businessSectors',
                    'Branches' => 'branches',
                ]
            ],
            // 6 => Customers
            'Customers' => [
                'name' =>  'customers',
                'is_provider' => false,
                'sub_items' => [
                    'Zones' => 'zones',
                    'SalesChannels' => 'salesChannels',
                    'BusinessSectors' => 'businessSectors',
                ]
            ],
            // 7 => Branches
            'Branches' => [
                'name' =>  'branches',
                'is_provider' => false,
                'sub_items' => [
                    'SalesChannels' => 'salesChannels',
                    // 'productI' => 'businessSectors',
                ]
            ],
            // 8 => ServiceProviders
            'ServiceProviders' => [
                'name' =>  'serviceProviders',
                'is_provider' => true,
                'sub_items' => [
                    'BusinessSectors' => 'businessSectors',
                    'Branches' => 'branches',
                    'SalesChannels' => 'salesChannels',
                    'Products' => 'products',
                ]
            ],
            // 9 => ServiceProvidersType
            'ServiceProvidersType' => [
                'name' =>  'serviceProvidersType',
                'is_provider' => true,
                'sub_items' => [
                    'BusinessSectors' => 'businessSectors',
                    'Branches' => 'branches',
                    'SalesChannels' => 'salesChannels',
                    'Products' => 'products',
                ]
            ],
            // 10 => ServiceProvidersBirthYear
            'ServiceProvidersBirthYear' => [
                'name' =>  'serviceProvidersBirthYear',
                'is_provider' => true,
                'sub_items' => [
                    'BusinessSectors' => 'businessSectors',
                    'Branches' => 'branches',
                    'SalesChannels' => 'salesChannels',
                    'Products' => 'products',
                ]
            ],
            // 11 => Countries
            'Countries' => [
                'name' =>  'countries',
                'is_provider' => false,
                'sub_items' => [
                    'SalesChannels' => 'salesChannels',
                    'BusinessSectors' => 'businessSectors',
                    'ProductsItems' => 'Items',
                ]
            ],
        ];
    }


     public function  twoDimensionalRankingsRoutes()
    {
        return [

             'Branches' => [
                'name' =>  'branches',
                'is_provider' => false,
                'sub_items' => [
                    'ProductsItems' => 'Items',
                ]
            ],

        ];
    }

}
