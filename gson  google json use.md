json api use gson  google json use 

<!-- TOC -->

- [str 2 json obj](#str-2-json-obj)
- [str2 json arr](#str2-json-arr)
- [get jsonarr from jsonobj](#get-jsonarr-from-jsonobj)
- [foreach jsonarr](#foreach-jsonarr)
- [get json obj attr](#get-json-obj-attr)

<!-- /TOC -->

#  obj2str   ,,foreach jsonobj
	Map m=Maps.newConcurrentMap();
		m.put("k1",111);m.put("k2", 222);
		String t= new Gson().toJson(m);
		JsonObject JsonObject1= new JsonParser().parse(t).getAsJsonObject();
		Set<Entry<String, JsonElement>>  setE=	JsonObject1.entrySet();
		 for (Entry<String, JsonElement> entry : setE) {
			System.out.println(entry.getKey());
			System.out.println(entry.getValue());
		}

# str 2 json obj
new JsonParser().parse(t).getAsJsonObject()

# str2 json arr

# get jsonarr from jsonobj

	JsonArray ja = json.getAsJsonArray("data");

# foreach jsonarr

		for (JsonElement  item : ja) {

# get json obj attr

 JsonElement1_item.getAsJsonObject().get("id").getAsString()           