using DevExpress.Xpf.Map;
using MaterialDesignThemes.Wpf;
using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.ComponentModel;
using System.Data;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Data;
using System.Windows.Documents;
using System.Windows.Input;
using System.Windows.Media;
using System.Windows.Media.Imaging;
using System.Windows.Navigation;
using System.Windows.Shapes;
using System.Linq;
using System.Linq.Expressions;
using System.Security;
using System.Runtime.InteropServices;


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
        private BackgroundWorker bgw = new BackgroundWorker();
        private MapItemStorage storeRegion;
        private MapItemStorage storeLocal;
        private MapItemStorage storeDepartement;
        private bool Islogged = false;
        public ObservableCollection<MapPushpin> MapItems { get; set; }
        

        public MainWindow()
        {
            InitializeComponent();
            MapItems = new ObservableCollection<MapPushpin>();
            
        
            PaletteHelper mainpalettehelper = new PaletteHelper();
            mainpalettehelper.ReplacePrimaryColor("blue");
            mainpalettehelper.ReplaceAccentColor("amber");


            adhesionTA = new DataSet2TableAdapters.ADHESION_DETAILTableAdapter();
            departementTA = new DataSet2TableAdapters.DEPARTEMENTSTableAdapter();
            regionsTA = new DataSet2TableAdapters.REGIONSTableAdapter();
            villesTA = new DataSet2TableAdapters.VILLESTableAdapter();
            nbadhlocationTA = new DataSet2TableAdapters.NB_PERS_CODEPOSTTableAdapter();
            beneTA = new DataSet2TableAdapters.BENEFICIAIRETableAdapter();
            querieTA = new DataSet2TableAdapters.QueriesTableAdapter();

            dataset = new DataSet2();

           //MessageBox.Show(querieTA.MOYENNE_SOINS_SEXE("M").ToString());
           //MessageBox.Show(querieTA.MOYENNE_SOINS_SEXE("F").ToString());

            nbadhlocationTA.Fill(dataset.NB_PERS_CODEPOST);
            adhesionTA.Fill(dataset.ADHESION_DETAIL);
            departementTA.Fill(dataset.DEPARTEMENTS);
            regionsTA.Fill(dataset.REGIONS);
            villesTA.Fill(dataset.VILLES);
            beneTA.Fill(dataset.BENEFICIAIRE);


            benegrid.ItemsSource = dataset.BENEFICIAIRE;
            adhgrid.ItemsSource = dataset.ADHESION_DETAIL;
            regiongrid.ItemsSource = dataset.REGIONS;
            depgrid.ItemsSource = dataset.DEPARTEMENTS;
            villegrid.ItemsSource = dataset.VILLES;
            
        }

        

        

      

        private void Window_Loaded(object sender, RoutedEventArgs e)
        {

            

            
            //faire la liste de pushpin pour les regions 

            foreach (DataSet2.DEPARTEMENTSRow elem in dataset.DEPARTEMENTS)
            {
                var numdep = elem.NUM_DEPARTEMENT;
                try
                {
                    var charttemp = dataset.ADHESION_DETAIL.Where(f => f.CODE_POSTAL.ToString().Substring(0, 2) == numdep.ToString()).Count();

                    histo.Points.Add(new DevExpress.Xpf.Charts.SeriesPoint()
                    {
                        Value = (double)charttemp,
                        Argument = elem.LIB_DEPARTEMENT.ToString()

                    });



                    



                }
                catch (Exception ex)
                {
                    MessageBox.Show(ex.ToString());

                }
            }
            mapctrl.CenterPoint = new GeoPoint(46.3453, 2.3605);


            storeRegion = new MapItemStorage();
            storeLocal = new MapItemStorage();
            storeDepartement = new MapItemStorage();



            foreach (DataSet2.NB_PERS_CODEPOSTRow elem in dataset.NB_PERS_CODEPOST) 
            {
                var pin = new MapPushpin() { Location = new GeoPoint((double)elem.VILLE_LATITUDE_DEG,(double)elem.VILLE_LONGITUDE_DEG ), Text = elem.NBPERS.ToString() , Information = elem.VILLE_CODE_POSTAL.ToString() };
                storeLocal.Items.Add(pin);
            }


            //var cmpt = 0;

            //for (int i = 1000; i < 96000; i+=10) 
            //{
            //   var nbadh = dataset.ADHESION_DETAIL.Where(f => f.CODE_POSTAL == i.ToString() && f.EXERCICE_PAIEMENT==2012).Count();
            //   if (nbadh != 0) 
            //   {
            //     //var villecourant = dataset.VILLES.First(g => g.VILLE_CODE_POSTAL == i.ToString());
            //       var villecourant = dataset.VILLES.FirstOrDefault(g => g.VILLE_CODE_POSTAL == i.ToString());
            //       if (villecourant != null)
            //       {
            //           var pin = new MapPushpin() { Location = new GeoPoint((double)villecourant.VILLE_LATITUDE_DEG, (double)villecourant.VILLE_LONGITUDE_DEG), Text = nbadh.ToString() };
            //           storea.Items.Add(pin);
            //       }
            //       cmpt += nbadh;
            //   }
            //}
            //MessageBox.Show(cmpt.ToString());



            foreach (DataSet2.REGIONSRow elem in dataset.REGIONS.Rows)
            {
                int nbadherant = 0;
                //bool firstpassage = true;
                foreach (DataSet2.DEPARTEMENTSRow elem2 in dataset.DEPARTEMENTS)
                {
                    if (elem2.NUM_REGION == elem.NUM_REGION)
                    {
                        var numdep = elem2.NUM_DEPARTEMENT;
                        var tempnb = dataset.ADHESION_DETAIL.Where(f => f.CODE_POSTAL.ToString().Substring(0, 2) == numdep.ToString()).Count();
                        //MessageBox.Show(dataset.NB_PERS_CODEPOST.Where(f => f.VILLE_CODE_POSTAL.ToString().Substring(0, 2) == numdep.ToString()).Count().ToString());
                        //if (firstpassage == true)
                        //{
                            var locdep = dataset.NB_PERS_CODEPOST.Where(f => (f.VILLE_CODE_POSTAL.ToString().Substring(0, 2) == numdep.ToString())).FirstOrDefault();
                            if (locdep != null)
                            {
                                var deppin = new MapPushpin() { Location = new GeoPoint((double)locdep.VILLE_LATITUDE_DEG, (double)locdep.VILLE_LONGITUDE_DEG), Text = tempnb.ToString(), Information = elem2.LIB_DEPARTEMENT.ToString() };
                                storeDepartement.Items.Add(deppin);
                            }
                            //firstpassage = false;
                        //}
                        nbadherant += tempnb;
                    }
                }
                //if (elem.NUM_REGION == 11) { MessageBox.Show(nbadherant.ToString()); }
                var pin = new MapPushpin() { Location = new GeoPoint(elem.LONGITUDE, elem.LATITUDE), Text = nbadherant.ToString() , Information = elem.LIB_REGION };

                storeRegion.Items.Add(pin);

                histo2.Points.Add(new DevExpress.Xpf.Charts.SeriesPoint()
                {
                    Value = (double)nbadherant,
                    Argument = elem.LIB_REGION.ToString()

                });

            }

                //vectorlayer.SelectedItems.Add(new MapPushpin() {Location = new GeoPoint(46,2) });
                //vectorlayer.DataContext = new MapPushpin() {Location = new GeoPoint(46,2) };
                //var compteur = 0;
                //foreach (DataSet2.VILLESRow elem in dataset.VILLES.Select("group by ville_code_postal"))
                //{
                //if (compteur < 2000)
                //{
                //var pin = new MapPushpin() { Location = new GeoPoint((double)elem.VILLE_LATITUDE_DEG, (double)elem.VILLE_LONGITUDE_DEG), Text = "V" };

                //storea.Items.Add(pin);
                //}
                //compteur++;
                //}
                //.GroupBy(row => row.Field<string>("ville_code_postal"))



                //int cmp = 0;
                //foreach (DataSet2.VILLESRow elem in dataset.VILLES) 
                //{
                //    if (cmp < 1000) { 
                //   var nbadh = dataset.ADHESION_DETAIL.Where(f => f.CODE_POSTAL == elem.VILLE_CODE_POSTAL).Count();
                //   var pin = new MapPushpin() { Location = new GeoPoint((double)elem.VILLE_LATITUDE_DEG, (double)elem.VILLE_LONGITUDE_DEG), Text = nbadh.ToString() };

                //   storea.Items.Add(pin);

                //   cmp++;
                //        }
                //}



                //MessageBox.Show(cmp.ToString());

                //vectorlayer.Data = storeRegion;
            this.vectorlayerDepartement.Data = storeDepartement;
            this.vectorlayerLocal.Data = storeLocal;
            this.vectorlayerRegion.Data = storeRegion;

            this.vectorlayerDepartement.Visibility = System.Windows.Visibility.Hidden;
            this.vectorlayerLocal.Visibility = System.Windows.Visibility.Hidden;
            this.vectorlayerRegion.Visibility = System.Windows.Visibility.Visible;
        }

        private void vectorlayer_ViewportChanged(object sender, ViewportChangedEventArgs e)
        {
           // App.Current.Dispatcher.BeginInvoke(new Action(() => { MessageBox.Show(this.mapctrl.ZoomLevel.ToString()); }));
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

           //App.Current.Dispatcher.BeginInvoke(new Action(()=>{MessageBox.Show(mapctrl.ZoomLevel.ToString());}));
            
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
           //App.Current.Dispatcher.BeginInvoke(new Action(()=>{ MessageBox.Show("toto");}));
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
            //MessageBox.Show(cmp.ToString());
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
           // MessageBox.Show(cmp.ToString());
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
            //MessageBox.Show(cmp.ToString());
        }

        

        
       
       

        

       


        //private IMapDataAdapter CreateData()
        //{
        //    // Create an object to load data from a shapefile.
        //    ShapefileDataAdapter loader = new ShapefileDataAdapter();

        //    // Determine the path to the Shapefile.
        //    Uri baseUri = new Uri(System.Reflection.Assembly.GetEntryAssembly().Location);
        //    string shapefilePath = "../../Data/Countries.shp";
        //    loader.FileUri = new Uri(baseUri, shapefilePath);

        //    return loader;
        //}

        //private MapColorizer CreateColorizer()
        //{
        //    // Create a graph colorizer.
        //    GraphColorizer colorizer = new GraphColorizer();

        //    // Specify colors for the colorizer.
        //    colorizer.Colors.Add(Colors.Blue);
        //    colorizer.Colors.Add(Colors.Red);
        //    colorizer.Colors.Add(Colors.Green);
        //    return colorizer;
        //}
    }

}
