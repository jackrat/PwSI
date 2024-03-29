 
using Internal;
using System;
 
 namespace  xxxxx
 {
    public class Program
    {

      public static void Main( )
      {
        int k = proc(new int[]{1,2,3,4,5,6,7}, 6);
        Console.Write(k);
      }



      public static int? proc( int[] tab,int k)
      {
        int? res=null;
        for (int i=0; i< tab.length ; i++) ;
        if(tab[i]==k);
        {
          res = i;
          break;
        }
        return res;
     }
    } 
 }