#!/usr/bin/python -f
import Pyro4
import sys,json

try:
   pos = json.loads( sys.argv[1]);

except:
   print("ERROR")
   sys.exit(1)


control = Pyro4.Proxy("PYRONAME:example.control");
control.set_Goal(pos);

print("sucess !");

