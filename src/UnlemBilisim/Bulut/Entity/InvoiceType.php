<?php
/**
 * Created by PhpStorm.
 * User: orhangazibasli2
 * Date: 6.12.2016
 * Time: 14:27
 */

namespace UnlemBilisim\Bulut\Entity;


class InvoiceType
{
/*
UBLVersionID = new UBLVersionIDType { Value = "2.1" }, //uluslararası fatura standardı 2.1
CustomizationID = new CustomizationIDType { Value = "TR1.2" }, //fakat GİB UBLTR olarak isimlendirdiği Türkiye'ye özgü 1.2 efatura formatını kullanıyor.
                ProfileID = new ProfileIDType { Value = "TICARIFATURA" }, //ticari ve temel olarak iki çeşittir. ticari faturalarda sistem yanıtı(application response) döner.
                CopyIndicator = new CopyIndicatorType { Value = false }, //kopyası mı, asıl süret mi olduğu belirlenir
                UUID = new UUIDType { Value = Guid.NewGuid().ToString() }, //fatura id

                IssueDate = new IssueDateType //fatura tarihi
                {
                Value = tarih1
                },

                InvoiceTypeCode = new InvoiceTypeCodeType { Value = "SATIS" }, //gönderilecek fatura çeşidi, satış, iade vs.
                Note = new NoteType[] { new NoteType() { Value = "asdasda" } }, //isteğe bağlı not alanı
                DocumentCurrencyCode = new DocumentCurrencyCodeType { Value = "TRY" }, //efatura para birimi
                LineCountNumeric = new LineCountNumericType { Value = 1 }, //fatura kalemlerinin sayısı

                AdditionalDocumentReference = new DocumentReferenceType[]
                {
                    new DocumentReferenceType()
                    {
                        ID = new IDType { Value = Guid.NewGuid().ToString() },

                        IssueDate = new IssueDateType
                        {
                        Value = tarih1
                        },

                        DocumentTypeCode = new DocumentTypeCodeType { Value = "CUST_INV_ID" }
                    },

                    new DocumentReferenceType()
                    {
                        ID = new IDType { Value = Guid.NewGuid().ToString() },

                        IssueDate = new IssueDateType
                        {
                        Value = tarih1
                        },

                        DocumentTypeCode = new DocumentTypeCodeType { Value = "XSLT" },
                        DocumentType = new DocumentTypeType { Value = "XSLT" },
                        Attachment = new AttachmentType
                        {
                        EmbeddedDocumentBinaryObject = new EmbeddedDocumentBinaryObjectType
                        {
                        characterSetCode = "UTF-8",
                                encodingCode = "Base64",
                                filename = "IN72015000001989.xslt",
                                mimeCode = "application/xml"
                            }
                        }
                    }
                },

                AccountingSupplierParty = new SupplierPartyType //gönderenin fatura üzerindeki bilgileri
                {
                Party = new PartyType()
                    {
                        WebsiteURI = new WebsiteURIType { Value = "web sitesi" },

                        PartyIdentification = new PartyIdentificationType[]
                        {
                            new PartyIdentificationType() { ID = new IDType { schemeID = "VKN", Value = TCKN_VKN } }
                        },

                        PartyName = new PartyNameType { Name = new NameType1 { Value = "asdasd" } },

                        PostalAddress = new AddressType
                        {
                        Room = new RoomType { Value = "kapi no" },
                            StreetName = new StreetNameType { Value = "cadde" },
                            BuildingName = new BuildingNameType { Value = "bina" },
                            BuildingNumber = new BuildingNumberType { Value = "bina no" },
                            CitySubdivisionName = new CitySubdivisionNameType { Value = "mahalle" },
                            CityName = new CityNameType { Value = "sehir" },
                            PostalZone = new PostalZoneType { Value = "posta kodu" },
                            Region = new RegionType { Value = "asdasd" },
                            Country = new CountryType { Name = new NameType1 { Value = "ülke" } }
                        },

                        PartyTaxScheme = new PartyTaxSchemeType
                        {
                        TaxScheme = new TaxSchemeType { Name = new NameType1 { Value = "vergi dairesi" } }
                        },

                        Contact = new ContactType
                        {
                        Telephone = new TelephoneType { Value = "telefon" },
                            Telefax = new TelefaxType { Value = "faks" },
                            ElectronicMail = new ElectronicMailType { Value = "mail" }
                        }
                    }
                },

                AccountingCustomerParty = new CustomerPartyType //Alıcının fatura üzerindeki bilgileri
                {
                Party = new PartyType
                {
                WebsiteURI = new WebsiteURIType { Value = "http:\\www.gib.gov.tr" },

                        PartyIdentification = new PartyIdentificationType[]
                        {
                            new PartyIdentificationType()
                            {
                                ID = new IDType { schemeID = "VKN", Value = TCKN_VKN }
                            }
                        },

                        PartyName = new PartyNameType
                        {
                        Name = new NameType1 { Value = "1" }
                        },

                        PostalAddress = new AddressType
                        {
                        StreetName = new StreetNameType { Value = "Etlik Cad." },
                            BuildingName = new BuildingNameType { Value = "Gelir İdaresi Ek Hizmet Binası" },
                            BuildingNumber = new BuildingNumberType { Value = "16" },
                            CitySubdivisionName = new CitySubdivisionNameType { Value = "Dışkapı" },
                            CityName = new CityNameType { Value = "Ankara" },
                            PostalZone = new PostalZoneType { Value = "06110" },

                            Country = new CountryType { Name = new NameType1 { Value = "Türkiye" } }
                        },

                        PartyTaxScheme = new PartyTaxSchemeType
                        {
                        TaxScheme = new TaxSchemeType { Name = new NameType1 { Value = "Dışkapı" } }
                        },

                        Contact = new ContactType
                        {
                        Telephone = new TelephoneType { Value = "asdasd" },
                            Telefax = new TelefaxType { Value = "asdasd" },
                            ElectronicMail = new ElectronicMailType { Value = "efatura@gib.gov.tr" }
                        }
                    }
                },

                AllowanceCharge = new AllowanceChargeType[]
                {
                    new AllowanceChargeType()
                    {
                        ChargeIndicator = new ChargeIndicatorType { Value = false },

                        Amount = new AmountType2 { currencyID = "TRY", Value = 0.01M }
                    }
                },

                TaxTotal = new TaxTotalType[]
                {
                    new TaxTotalType()
                    {
                        TaxAmount = new TaxAmountType
                        {
                        currencyID = "TRY",
                            Value = 0.01M
                        },

                        TaxSubtotal = new TaxSubtotalType[]
                        {
                            new TaxSubtotalType()
                            {
                                TaxableAmount = new TaxableAmountType
                                {
                                currencyID = "TRY",
                                    Value = 0.99M
                                },

                                TaxAmount = new TaxAmountType
                                {
                                currencyID = "TRY",
                                    Value = 0.01M
                                },

                                TaxCategory = new TaxCategoryType
                                {
                                TaxScheme = new TaxSchemeType
                                {
                                Name = new NameType1 { Value = "KDV" },
                                        TaxTypeCode = new TaxTypeCodeType { Value = "0015" }
                                    }
                                }
                            },
                        }
                    }
                },

                LegalMonetaryTotal = new MonetaryTotalType
                {
                LineExtensionAmount = new LineExtensionAmountType { currencyID = "TRY", Value = 1 },

                    TaxExclusiveAmount = new TaxExclusiveAmountType { currencyID = "TRY", Value = 0.99M },

                    TaxInclusiveAmount = new TaxInclusiveAmountType { currencyID = "TRY", Value = 1 },

                    AllowanceTotalAmount = new AllowanceTotalAmountType { currencyID = "TRY", Value = 0.01M },

                    PayableAmount = new PayableAmountType { currencyID = "TRY", Value = 1 }
                },

                InvoiceLine = new InvoiceLineType[]
                {
                    new InvoiceLineType()
                    {
                        ID = new IDType { Value = "1" },
                        InvoicedQuantity = new InvoicedQuantityType { unitCode = "CMT", Value = 1 },
                        LineExtensionAmount = new LineExtensionAmountType { currencyID = "TRY", Value = 0.99M },

                        AllowanceCharge = new AllowanceChargeType[]
                        {
                            new AllowanceChargeType()
                            {
                                ChargeIndicator = new ChargeIndicatorType { Value = false },
                                MultiplierFactorNumeric = new MultiplierFactorNumericType { Value = 0.01M },

                                Amount = new AmountType2
                                {
                                currencyID = "TRY",
                                    Value = 0.01M
                                },

                                BaseAmount = new BaseAmountType
                                {
                                currencyID = "TRY",
                                    Value = 1
                                }
                            }
                        },

                        TaxTotal = new TaxTotalType
                        {
                        TaxAmount = new TaxAmountType
                        {
                        currencyID = "TRY",
                                Value = 0.01M
                            },

                            TaxSubtotal = new TaxSubtotalType[]
                            {
                                new TaxSubtotalType()
                                {
                                    TaxableAmount = new TaxableAmountType
                                    {
                                    currencyID = "TRY",
                                        Value = 0.99M
                                    },

                                    TaxAmount = new TaxAmountType
                                    {
                                    currencyID = "TRY",
                                        Value = 0.01M
                                    },

                                    Percent = new PercentType1 { Value = 1 },

                                    TaxCategory = new TaxCategoryType
                                    {
                                    TaxScheme = new TaxSchemeType
                                    {
                                    Name = new NameType1 { Value = "KDV" },
                                            TaxTypeCode = new TaxTypeCodeType { Value = "0015" }
                                        }
                                    }
                                }
                            },
                        },

                        Item = new ItemType
                        {
                        Name = new NameType1 { Value = "asdads" }
                        },

                        Price = new PriceType
                        {
                        PriceAmount = new PriceAmountType
                        {
                        currencyID = "TRY",
                                Value = 1
                            }
                        }
                    }
                }
            };*/
}