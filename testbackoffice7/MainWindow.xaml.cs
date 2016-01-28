using DevExpress.Xpf.Map;
using MaterialDesignThemes.Wpf;
using System;
using System.Collections.ObjectModel;
using System.ComponentModel;
using System.Data;
using System.Linq;
using System.Windows;
using System.Windows.Controls;


namespace testbackoffice7
{
    /// <summary>
    /// Logique d'interaction pour MainWindow.xaml
    /// </summary>
    public partial class MainWindow : Window
    {
        private DataSet2 dataset;
        private DataSet2TableAdapters.ADHESION_DETAILTableAdapter adhesionTA;
        private DataSet2TableAdapters.DEPARTEMENTSTableAdapter departementTA;
        private DataSet2TableAdapters.REGIONSTableAdapter regionsTA;
        private DataSet2TableAdapters.VILLESTableAdapter villesTA;
        private DataSet2TableAdapters.NB_PERS_CODEPOSTTableAdapter nbadhlocationTA;
        private DataSet2TableAdapters.BENEFICIAIRETableAdapter beneTA;
        private DataSet2TableAdapters.QueriesTableAdapter querieTA;
        private DataSet2TableAdapters.SOINSTableAdapter soinsTA;
        private DataSet2TableAdapters.PRESTATIONS_SANTETableAdapter prestaTA;
        private BackgroundWorker bgw = new BackgroundWorker();
        private MapItemStorage storeRegion;
        private MapItemStorage storeLocal;
        private MapItemStorage storeDepartement;
        
        private bool Islogged = false;
        public ObservableCollection<MapPushpin> MapItems { get; set; }
        private BackgroundWorker bw;

        public MainWindow()
        {
            InitializeComponent();
            MapItems = new ObservableCollection<MapPushpin>();
            bw = new BackgroundWorker();
            bw.DoWork +=bw_DoWork;
            bw.RunWorkerCompleted +=bw_RunWorkerCompleted;
            
            PaletteHelper mainpalettehelper = new PaletteHelper();
            mainpalettehelper.ReplacePrimaryColor("blue");
            mainpalettehelper.ReplaceAccentColor("amber");

            prestaTA = new DataSet2TableAdapters.PRESTATIONS_SANTETableAdapter();
            adhesionTA = new DataSet2TableAdapters.ADHESION_DETAILTableAdapter();
            departementTA = new DataSet2TableAdapters.DEPARTEMENTSTableAdapter();
            regionsTA = new DataSet2TableAdapters.REGIONSTableAdapter();
            villesTA = new DataSet2TableAdapters.VILLESTableAdapter();
            nbadhlocationTA = new DataSet2TableAdapters.NB_PERS_CODEPOSTTableAdapter();
            beneTA = new DataSet2TableAdapters.BENEFICIAIRETableAdapter();
            querieTA = new DataSet2TableAdapters.QueriesTableAdapter();
            soinsTA = new DataSet2TableAdapters.SOINSTableAdapter();
            dataset = new DataSet2();

            storeRegion = new MapItemStorage();
            storeLocal = new MapItemStorage();
            storeDepartement = new MapItemStorage();



            
            
            
        }

        private void bw_RunWorkerCompleted(object sender, RunWorkerCompletedEventArgs e)
        {
            var tmp = (DataSet2)e.Result;
            dataset.Merge(tmp);
            benegrid.ItemsSource = dataset.BENEFICIAIRE;
            adhgrid.ItemsSource = dataset.ADHESION_DETAIL;
            regiongrid.ItemsSource = dataset.REGIONS;
            depgrid.ItemsSource = dataset.DEPARTEMENTS;
            villegrid.ItemsSource = dataset.VILLES;











            
            this.vectorlayerDepartement.Data = storeDepartement;
            this.vectorlayerLocal.Data = storeLocal;
            this.vectorlayerRegion.Data = storeRegion;

            this.vectorlayerDepartement.Visibility = System.Windows.Visibility.Hidden;
            this.vectorlayerLocal.Visibility = System.Windows.Visibility.Hidden;
            this.vectorlayerRegion.Visibility = System.Windows.Visibility.Visible;
            
        }

        private void bw_DoWork(object sender, DoWorkEventArgs e)
        {
            var dts = new DataSet2();
            nbadhlocationTA.Fill(dts.NB_PERS_CODEPOST);
            adhesionTA.Fill(dts.ADHESION_DETAIL);
            departementTA.Fill(dts.DEPARTEMENTS);
            regionsTA.Fill(dts.REGIONS);
            villesTA.Fill(dts.VILLES);
            beneTA.Fill(dts.BENEFICIAIRE);
            soinsTA.Fill(dts.SOINS);
           



            foreach (DataSet2.DEPARTEMENTSRow elem in dts.DEPARTEMENTS)
            {
                var numdep = elem.NUM_DEPARTEMENT;
                try
                {
                    var charttemp = dts.ADHESION_DETAIL.Where(f => f.CODE_POSTAL.ToString().Substring(0, 2) == numdep.ToString()).Count();
                    App.Current.Dispatcher.BeginInvoke(new Action(() =>
                    {
                        histo.Points.Add(new DevExpress.Xpf.Charts.SeriesPoint()
                        {
                            Value = (double)charttemp,
                            Argument = elem.LIB_DEPARTEMENT.ToString()

                        });
                    }));







                }
                catch (Exception ex)
                {
                    MessageBox.Show(ex.ToString());

                }
            }
            App.Current.Dispatcher.BeginInvoke(new Action(() =>
            {
                mapctrl.CenterPoint = new GeoPoint(46.3453, 2.3605);
            }));


            



            foreach (DataSet2.NB_PERS_CODEPOSTRow elem in dts.NB_PERS_CODEPOST)
            {
                App.Current.Dispatcher.BeginInvoke(new Action(() =>
                { 

                var pin = new MapPushpin() { Location = new GeoPoint((double)elem.VILLE_LATITUDE_DEG, (double)elem.VILLE_LONGITUDE_DEG), Text = elem.NBPERS.ToString(), Information = elem.VILLE_CODE_POSTAL.ToString() };
                
                storeLocal.Items.Add(pin); }));
                    
                
            }






            foreach (DataSet2.REGIONSRow elem in dts.REGIONS.Rows)
            {
                int nbadherant = 0;

                foreach (DataSet2.DEPARTEMENTSRow elem2 in dts.DEPARTEMENTS)
                {
                    if (elem2.NUM_REGION == elem.NUM_REGION)
                    {
                        var numdep = elem2.NUM_DEPARTEMENT;
                        var tempnb = dts.ADHESION_DETAIL.Where(f => f.CODE_POSTAL.ToString().Substring(0, 2) == numdep.ToString()).Count();

                        var locdep = dts.NB_PERS_CODEPOST.Where(f => (f.VILLE_CODE_POSTAL.ToString().Substring(0, 2) == numdep.ToString())).FirstOrDefault();
                        if (locdep != null)
                        {
                            App.Current.Dispatcher.BeginInvoke(new Action(() =>
                            {
                            var deppin = new MapPushpin() { Location = new GeoPoint((double)locdep.VILLE_LATITUDE_DEG, (double)locdep.VILLE_LONGITUDE_DEG), Text = tempnb.ToString(), Information = elem2.LIB_DEPARTEMENT.ToString() };
                            
                             storeDepartement.Items.Add(deppin); }));
                                
                            
                        }

                        nbadherant += tempnb;
                    }
                }
                App.Current.Dispatcher.BeginInvoke(new Action(() =>
                { 
                var pin = new MapPushpin() { Location = new GeoPoint(elem.LONGITUDE, elem.LATITUDE), Text = nbadherant.ToString(), Information = elem.LIB_REGION };
                
                storeRegion.Items.Add(pin); }));
                  

                App.Current.Dispatcher.BeginInvoke(new Action(() => {
                histo2.Points.Add(new DevExpress.Xpf.Charts.SeriesPoint()
                {
                    Value = (double)nbadherant,
                    Argument = elem.LIB_REGION.ToString()

                });
                }));







            }

            decimal? nbprest;

            querieTA.NB_PRESTA(out nbprest);
            foreach (DataSet2.SOINSRow elem in dataset.SOINS)
            {
                decimal? ressoins;
                double resfinal;
                
                
                querieTA.NB_PRESTA_SOINS(elem.DESIGNATION_ACTE, out ressoins);
                resfinal = (double)ressoins / (double)nbprest;

                App.Current.Dispatcher.BeginInvoke(new Action(() =>
                {
                    histo3.Points.Add(new DevExpress.Xpf.Charts.SeriesPoint()
                    {
                        Value = (double)resfinal,
                        Argument = elem.DESIGNATION_ACTE

                    });
                }));
                
            }

            e.Result = dts;
        }

        

        

      

        private void Window_Loaded(object sender, RoutedEventArgs e)
        {



            bw.RunWorkerAsync();
            


        }

        private void vectorlayer_ViewportChanged(object sender, ViewportChangedEventArgs e)
        {
          
            if (mapctrl.ZoomLevel >= 9) 
            {
                this.vectorlayerLocal.Visibility = System.Windows.Visibility.Visible;
                this.vectorlayerRegion.Visibility = System.Windows.Visibility.Hidden;
                this.vectorlayerDepartement.Visibility = System.Windows.Visibility.Hidden;
            }
            else if (mapctrl.ZoomLevel >=7  )
            {
                this.vectorlayerLocal.Visibility = System.Windows.Visibility.Hidden;
                this.vectorlayerRegion.Visibility = System.Windows.Visibility.Hidden;
                this.vectorlayerDepartement.Visibility = System.Windows.Visibility.Visible;
            }
            else
            {
                this.vectorlayerLocal.Visibility = System.Windows.Visibility.Hidden;
                this.vectorlayerRegion.Visibility = System.Windows.Visibility.Visible;
                this.vectorlayerDepartement.Visibility = System.Windows.Visibility.Hidden;
            }

           
            
        }

        private void Button_Click(object sender, RoutedEventArgs e)
        {
            if (login.Text == "admin" && Utils.ConvertToUnsecureString(mdp.SecurePassword) == "admin" || Islogged == true) 
            {
                Islogged = true;
                indictab.IsSelected = true;
                
            }
            
        }

        private void maintab_SelectionChanged(object sender, SelectionChangedEventArgs e)
        {
           
            if (Islogged == false) 
            {
                home.IsSelected = true;
            }
        }

        private void Button_Click_1(object sender, RoutedEventArgs e)
        {
            if (Islogged == true) 
            {
                Islogged = false;
                home.IsSelected = true;
            }
        }

        private void Button_Click_2(object sender, RoutedEventArgs e)//adherant table
        {
            try
            {
                adhesionTA.Update(dataset.ADHESION_DETAIL);
            }
            catch (Exception ex) 
            {
                MessageBox.Show(ex.ToString());
            }

        }

        private void Button_Click_3(object sender, RoutedEventArgs e)
        {
            mapctrl.ZoomLevel = 5;
        }

        private void Button_Click_4(object sender, RoutedEventArgs e)
        {
            mapctrl.ZoomLevel = 7;
        }

        private void Button_Click_5(object sender, RoutedEventArgs e)
        {
            mapctrl.ZoomLevel = 9;
        }

        

        private void Button_Click_6(object sender, RoutedEventArgs e)
        {
            
            int cmp = 0;
            
            foreach (MapPushpin elem in storeRegion.DisplayItems) 
            {
                if (elem.Information.ToString().ToUpper() == this.rechtext.Text.ToString().ToUpper()) 
                {
                    mapctrl.CenterPoint = elem.Location;
                    mapctrl.ZoomLevel = 6.5f;
                    cmp++;
                }
                
            }
           
            if (cmp == 0) 
            {
                foreach (MapPushpin elem in storeDepartement.DisplayItems)
                {
                    if (elem.Information.ToString().ToUpper() == this.rechtext.Text.ToString().ToUpper())
                    {
                        mapctrl.CenterPoint = elem.Location;
                        mapctrl.ZoomLevel = 8f;
                        cmp++;
                    }
                    
                }
            }
           
            if (cmp == 0) 
            {
                foreach (MapPushpin elem in storeLocal.DisplayItems)
                {
                    if (elem.Information.ToString() == this.rechtext.Text.ToString().ToUpper())
                    {
                        mapctrl.CenterPoint = elem.Location;
                        mapctrl.ZoomLevel = 11;
                        cmp++;
                    }
                    
                }
            }
            
        }

    }

}
