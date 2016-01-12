using DevExpress.Xpf.Map;
using MaterialDesignThemes.Wpf;
using System;
using System.Collections.Generic;
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
        public MainWindow()
        {
            InitializeComponent();
            PaletteHelper mainpalettehelper = new PaletteHelper();
            mainpalettehelper.ReplacePrimaryColor("blue");
            mainpalettehelper.ReplaceAccentColor("amber");
            
            
        }

        private void Window_Loaded(object sender, RoutedEventArgs e)
        {
            adhesionTA = new DataSet2TableAdapters.ADHESION_DETAILTableAdapter();
            departementTA = new DataSet2TableAdapters.DEPARTEMENTSTableAdapter();
            dataset = new DataSet2();
            adhesionTA.Fill(dataset.ADHESION_DETAIL);
            departementTA.Fill(dataset.DEPARTEMENTS);
            benegrid.ItemsSource = dataset.ADHESION_DETAIL;

            foreach(DataSet2.DEPARTEMENTSRow elem in dataset.DEPARTEMENTS)
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
            ImageTilesLayer tmp = new ImageTilesLayer();

            //mapview.Layers.Add(new VectorLayer()
            //{
            //    Data = CreateData()
            //    Colorizer = CreateColorizer()
            //});
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
