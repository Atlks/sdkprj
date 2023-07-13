
import hashlib
#计算密码的md5值
def get_md5(s):
    md = hashlib.md5()
    md.update(s.encode('utf-8'))
    return md.hexdigest()