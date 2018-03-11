#!/usr/bin/python -f
import Pyro4
control = Pyro4.Proxy("PYRONAME:example.control");

node_visited = control.getVisistedSet()
node_env = control.getObstacleSet()

print(node_visited);
print("second");
print(node_env);
