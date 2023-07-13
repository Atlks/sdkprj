import os, sys

import platform

dir_name = os.path.dirname(__file__)


path=os.path.join(dir_name, "..", "..", "..", "dep", platform.system(), "%s.%s" % (sys.version_info.major, sys.version_info.minor), "lib")
#print("path:", os.path.abspath(path))
if os.path.exists(path):
    sys.path.append(path)
    
path=os.path.join(dir_name, "..", "..", "..", "dep", "%s.%s" % (sys.version_info.major, sys.version_info.minor), "lib")
if os.path.exists(path):
    sys.path.append(path)

path=os.path.join(dir_name, "..", "..", "..", "dep", "lib", "python")
if os.path.exists(path):
    sys.path.append(path)



path=os.path.join(dir_name, "..", "..", "dep", "lib", "python")
if os.path.exists(path):
    sys.path.append(path)

