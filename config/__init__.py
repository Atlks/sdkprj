# -*- coding: utf-8 -*-


from __future__ import print_function

produkt_name = "采集源管理"


from .system import *

from web import *

from .global_utils import *
from .flags import *
from . import variables

mac, _msg_err, ip = load_config()
if not mac:
     if _msg_err and variables.args["verbose"]:
         print("Error while loading config\n:%s" % _msg_err, file=sys.stderr)


from .shared_imports import *
from .template_globals import *


salt = "ddddd345908707890746443242345sdfgsdfg!$"

