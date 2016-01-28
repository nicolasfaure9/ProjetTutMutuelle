using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.IO;
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
    /// Logique d'interaction pour SortingUC.xaml
    /// </summary>
    public partial class SortingUC : UserControl
    {
        private BackgroundWorker bw;
        private BackgroundWorker bw2;
        private IEnumerable<string> Storedlines;
        List<String> lststring;
        public SortingUC()
        {
            InitializeComponent();
            lststring = new List<string>();
            bw = new BackgroundWorker() { WorkerReportsProgress = true, WorkerSupportsCancellation = true };
            bw2 = new BackgroundWorker() { WorkerReportsProgress = true, WorkerSupportsCancellation = true };
            bw.DoWork += bw_DoWork;
            bw2.DoWork += bw2_DoWork;
            bw.ProgressChanged += bw_ProgressChanged;
            bw2.ProgressChanged += bw2_ProgressChanged;
            bw.RunWorkerCompleted += bw_RunWorkerCompleted;
            bw2.RunWorkerCompleted += bw2_RunWorkerCompleted;
            if (File.Exists(System.IO.Path.GetDirectoryName(App.ResourceAssembly.Location) + "\\mylittleOutput.csv"))
            {
                Storedlines = File.ReadLines(System.IO.Path.GetDirectoryName(App.ResourceAssembly.Location) + "\\mylittleOutput.csv").ToArray();
            }
            else
            {
               // MessageBox.Show("Veuillez generer le fichier csv");
            }
        }

        private void bw2_RunWorkerCompleted(object sender, RunWorkerCompletedEventArgs e)
        {
            // MessageBox.Show("")
        }

        private void bw2_ProgressChanged(object sender, ProgressChangedEventArgs e)
        {
            progress3.Value = e.ProgressPercentage;
        }

        private void bw2_DoWork(object sender, DoWorkEventArgs e)
        {

            var Storedlines = File.ReadLines(System.IO.Path.GetDirectoryName(App.ResourceAssembly.Location) + "\\myOutput.csv").ToArray();
            
            Quicksort(Storedlines, 0, Storedlines.Length - 1);

            var file = System.IO.Path.GetDirectoryName(App.ResourceAssembly.Location) + @"\myOutput3.csv";




            using (var stream = File.CreateText(file))
            {


                foreach (String elem in Storedlines.AsEnumerable())
                {


                    stream.WriteLine(elem);


                }


            }
            App.Current.Dispatcher.BeginInvoke(new Action(() => { MessageBox.Show("down"); }));

        }

        private void bw_RunWorkerCompleted(object sender, RunWorkerCompletedEventArgs e)
        {
            MessageBox.Show("down");
        }

        private void bw_ProgressChanged(object sender, ProgressChangedEventArgs e)
        {
            progress2.Value = e.ProgressPercentage;
        }

        private void bw_DoWork(object sender, DoWorkEventArgs e)
        {
            


            var lines = File.ReadLines(System.IO.Path.GetDirectoryName(App.ResourceAssembly.Location) + "\\mylittleOutput.csv").ToArray();

            bool echange = true;
            while (echange)
            {
                echange = false;
                for (int j = 0; j < lines.Count() - 1; j++)
                {


                    if (int.Parse(lines[j].Split(';')[2]) > int.Parse(lines[j + 1].Split(';')[2]))
                    {
                        string tmp = lines[j];
                        lines[j] = lines[j + 1];
                        lines[j + 1] = tmp;
                        echange = true;
                    }


                }


            }






            var file = System.IO.Path.GetDirectoryName(App.ResourceAssembly.Location) + @"\myOutput2.csv";




            using (var stream = File.CreateText(file))
            {


                foreach (String elem in lines.AsEnumerable())
                {


                    stream.WriteLine(elem);


                }


            }
            App.Current.Dispatcher.BeginInvoke(new Action(() => { MessageBox.Show("down"); }));

        }

        private void Button_Click(object sender, RoutedEventArgs e)
        {
            bw.RunWorkerAsync();
        }

        public static void Quicksort(String[] elements, int left, int right)
        {
            int i = left, j = right;
            int pivot = int.Parse(elements[(left + right) / 2].Split(';')[2]);

            while (i <= j)
            {
                while (int.Parse(elements[i].Split(';')[2]) > pivot)
                {
                    i++;
                }

                while (int.Parse(elements[j].Split(';')[2]) < pivot)
                {
                    j--;
                }

                if (i <= j)
                {
                    // Swap
                    String tmp = elements[i];
                    elements[i] = elements[j];
                    elements[j] = tmp;

                    i++;
                    j--;
                }
            }

            // Recursive calls
            if (left < j)
            {
                Quicksort(elements, left, j);
            }

            if (i < right)
            {
                Quicksort(elements, i, right);
            }
        }

        private void Button_Click_1(object sender, RoutedEventArgs e)
        {
            if (!bw2.IsBusy)
            {
                bw2.RunWorkerAsync();
            }
        }
    }
}
