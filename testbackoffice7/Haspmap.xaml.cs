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
    /// Logique d'interaction pour Haspmap.xaml
    /// </summary>
    public partial class Haspmap : UserControl
    {
        private Dictionary<string, List<string>> lst;
        private DataSet2TableAdapters.HASHTABLETableAdapter hta;

        private DataSet2 dataset;

        public Haspmap()
        {
            InitializeComponent();
            hta = new DataSet2TableAdapters.HASHTABLETableAdapter();
            dataset = new DataSet2();
           

            lst = new Dictionary<string, List<string>>();

        }

        private void Button_Click(object sender, RoutedEventArgs e)
        {
            foreach (DataSet2.HASHTABLERow elem in dataset.HASHTABLE)
            {
                if (!lst.ContainsKey(elem.CODE_PROFESSION.ToString()))
                {
                    lst.Add(elem.CODE_PROFESSION, new List<string> { elem.ACTE });
                }
                else
                {
                    lst.Where(f => f.Key.ToString() == elem.CODE_PROFESSION.ToString()).FirstOrDefault().Value.Add(elem.ACTE.ToString());
                }

            }

            dtg.ItemsSource = lst;
        }

        private void UserControl_Loaded(object sender, RoutedEventArgs e)
        {
         //   hta.Fill(dataset.HASHTABLE);
        }
    }
}
