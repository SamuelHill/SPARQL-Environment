-- USERS
INSERT INTO user (username, name, salt, password, email, bio)
    VALUES ('new_user', 'New User', '4b031099c78e1b7',
        'e1f823f33879d1820b5799d6a45684b26001385635b8cb8312ef2cc43d2bf2ae',
        'fake@gmail.com', 'A new user to the SPARQL-Environment');
INSERT INTO user (username, name, salt, password, email, bio)
    VALUES ('other_guy', 'Other User', '317e53952871f1fe',
        '97f8fd3e3cbacf32075a7830a994d0e65d380ffe7dad4cd33b4f3559edbb6065',
        'other@gmail.com', 'Another user to the SPARQL-Environment');

-- PLUGINS
INSERT INTO plugin (urn, name, description, config_doc_id, owner)
    VALUES ('sparqplug-detail-history', 'Detail History',
        'Utilizes the built in history document (in mongo) and saves queries for each view.',
        '56674305b292c90e2888faac', 'new_user');
INSERT INTO plugin (urn, name, description, config_doc_id, owner)
    VALUES ('sparqplug-detail-object', 'Detail Objects',
        'On selection of an object (node) show some basic information such as linked nodes and attributes.',
        '566741cdb292c9f82788faab', 'other_guy');
INSERT INTO plugin (urn, name, description, config_doc_id, owner)
    VALUES ('sparqplug-detail-saved', 'Detail Saved',
        'Save output of query.', '56674236b292c96a2888faa9', 'other_guy');
INSERT INTO plugin (urn, name, description, config_doc_id, owner)
    VALUES ('sparqplug-in-text', 'Input Text',
        'Allows you to create queries in plain text with code highlighting and auto completion.',
        '5666a0fdb292c9fb2788faa9', 'new_user');
INSERT INTO plugin (urn, name, description, config_doc_id, owner)
    VALUES ('sparqplug-out-json', 'Output Json',
        'Outputs the results of a query as json.',
        '56674281b292c9f92788faa9', 'other_guy');
INSERT INTO plugin (urn, name, description, config_doc_id, owner)
    VALUES ('sparqplug-out-table', 'Output Table',
        'Outputs the query results as a table.',
        '56674388b292c9fb2788faac', 'new_user');

-- DATASETS
INSERT INTO dataset (name, description, source, prefix_list)
    VALUES ('UK Legislation', 'Data on legislation for the UK.',
        'http://gov.tso.co.uk/legislation/sparql',
        '"rdf:":"http://www.w3.org/1999/02/22-rdf-syntax-ns#"');
INSERT INTO dataset (name, description, source, prefix_list, variable_list)
    VALUES ('example-fufolio', "An example of a dataset using Furman's HMT Project.",
        'http://folio.furman.edu/fuseki/folio/query',
        '"cts:":"http://www.homermultitext.org/cts/rdf/", "cite:":"http://www.homermultitext.org/cite/rdf/", "rdf:":"http://www.w3.org/1999/02/22-rdf-syntax-ns#"',
        '"?folio":{},"?image":{}');
INSERT INTO dataset (name, description, source, prefix_list, variable_list)
    VALUES ('DBpedia', "A crowd-sourced community effort to extract structured information from Wikipedia.",
        'http://dbpedia.org/sparql?default-graph-uri=http%3A%2F%2Fdbpedia.org&format=text%2Fjson&timeout=3000',
        '"a": "http://www.w3.org/2005/Atom","address": "http://schemas.talis.com/2005/address/schema#", "admin": "http://webns.net/mvcb/", "atom": "http://atomowl.org/ontologies/atomrdf#", "aws": "http://soap.amazon.com/", "b3s": "http://b3s.openlinksw.com/", "batch": "http://schemas.google.com/gdata/batch", "bibo": "http://purl.org/ontology/bibo/", "bif": "bif:", "bugzilla": "http://www.openlinksw.com/schemas/bugzilla#", "c": "http://www.w3.org/2002/12/cal/icaltzd#", "category": "http://dbpedia.org/resource/Category:", "cb": "http://www.crunchbase.com/", "cc": "http://web.resource.org/cc/", "content": "http://purl.org/rss/1.0/modules/content/", "cv": "http://purl.org/captsolo/resume-rdf/0.2/cv#", "cvbase": "http://purl.org/captsolo/resume-rdf/0.2/base#", "dawgt": "http://www.w3.org/2001/sw/DataAccess/tests/test-dawg#", "dbpedia": "http://dbpedia.org/resource/", "dbpedia-owl": "http://dbpedia.org/ontology/", "dbpprop": "http://dbpedia.org/property/", "dc": "http://purl.org/dc/elements/1.1/", "dcterms": "http://purl.org/dc/terms/", "digg": "http://digg.com/docs/diggrss/", "ebay": "urn:ebay:apis:eBLBaseComponents", "enc": "http://purl.oclc.org/net/rss_2.0/enc#", "exif": "http://www.w3.org/2003/12/exif/ns/", "fb": "http://api.facebook.com/1.0/", "ff": "http://api.friendfeed.com/2008/03", "fn": "http://www.w3.org/2005/xpath-functions/#", "foaf": "http://xmlns.com/foaf/0.1/", "freebase": "http://rdf.freebase.com/ns/", "g": "http://base.google.com/ns/1.0", "gb": "http://www.openlinksw.com/schemas/google-base#", "gd": "http://schemas.google.com/g/2005", "geo": "http://www.w3.org/2003/01/geo/wgs84_pos#", "geonames": "http://www.geonames.org/ontology#", "georss": "http://www.georss.org/georss", "gml": "http://www.opengis.net/gml", "go": "http://purl.org/obo/owl/GO#", "gr": "http://purl.org/goodrelations/v1#", "grs": "http://www.georss.org/georss/", "hlisting": "http://www.openlinksw.com/schemas/hlisting/", "hoovers": "http://wwww.hoovers.com/", "hrev": "http:/www.purl.org/stuff/hrev#", "ical": "http://www.w3.org/2002/12/cal/ical#", "ir": "http://web-semantics.org/ns/image-regions", "itunes": "http://www.itunes.com/DTDs/Podcast-1.0.dtd", "lgv": "http://linkedgeodata.org/ontology/", "link": "http://www.xbrl.org/2003/linkbase", "lod": "http://lod.openlinksw.com/", "math": "http://www.w3.org/2000/10/swap/math#", "media": "http://search.yahoo.com/mrss/", "mesh": "http://purl.org/commons/record/mesh/", "meta": "urn:oasis:names:tc:opendocument:xmlns:meta:1.0", "mf": "http://www.w3.org/2001/sw/DataAccess/tests/test-manifest#", "mmd": "http://musicbrainz.org/ns/mmd-1.0#", "mo": "http://purl.org/ontology/mo/", "mql": "http://www.freebase.com/", "nci": "http://ncicb.nci.nih.gov/xml/owl/EVS/Thesaurus.owl#", "nfo": "http://www.semanticdesktop.org/ontologies/nfo/#", "ng": "http://www.openlinksw.com/schemas/ning#", "nyt": "http://www.nytimes.com/", "oai": "http://www.openarchives.org/OAI/2.0/", "oai_dc": "http://www.openarchives.org/OAI/2.0/oai_dc/", "obo": "http://www.geneontology.org/formats/oboInOwl#", "office": "urn:oasis:names:tc:opendocument:xmlns:office:1.0", "ogc": "http://www.opengis.net/", "ogcgml": "http://www.opengis.net/ont/gml#", "ogcgs": "http://www.opengis.net/ont/geosparql#", "ogcgsf": "http://www.opengis.net/def/function/geosparql/", "ogcgsr": "http://www.opengis.net/def/rule/geosparql/", "ogcsf": "http://www.opengis.net/ont/sf#", "oo": "urn:oasis:names:tc:opendocument:xmlns:meta:1.0:", "openSearch": "http://a9.com/-/spec/opensearchrss/1.0/", "opencyc": "http://sw.opencyc.org/2008/06/10/concept/", "opl": "http://www.openlinksw.com/schema/attribution#", "opl-gs": "http://www.openlinksw.com/schemas/getsatisfaction/", "opl-meetup": "http://www.openlinksw.com/schemas/meetup/", "opl-xbrl": "http://www.openlinksw.com/schemas/xbrl/", "oplweb": "http://www.openlinksw.com/schemas/oplweb#", "ore": "http://www.openarchives.org/ore/terms/", "owl": "http://www.w3.org/2002/07/owl#", "product": "http://www.buy.com/rss/module/productV2/", "protseq": "http://purl.org/science/protein/bysequence/", "r": "http://backend.userland.com/rss2", "radio": "http://www.radiopop.co.uk/", "rdf": "http://www.w3.org/1999/02/22-rdf-syntax-ns#", "rdfa": "http://www.w3.org/ns/rdfa#", "rdfdf": "http://www.openlinksw.com/virtrdf-data-formats#", "rdfs": "http://www.w3.org/2000/01/rdf-schema#", "rev": "http://purl.org/stuff/rev#", "review": "http:/www.purl.org/stuff/rev#", "rss": "http://purl.org/rss/1.0/", "sc": "http://purl.org/science/owl/sciencecommons/", "scovo": "http://purl.org/NET/scovo#", "sd": "http://www.w3.org/ns/sparql-service-description#", "sf": "urn:sobject.enterprise.soap.sforce.com", "sioc": "http://rdfs.org/sioc/ns#", "sioct": "http://rdfs.org/sioc/types#", "skos": "http://www.w3.org/2004/02/skos/core#", "slash": "http://purl.org/rss/1.0/modules/slash/", "sql": "sql:", "stock": "http://xbrlontology.com/ontology/finance/stock_market#", "twfy": "http://www.openlinksw.com/schemas/twfy#", "umbel": "http://umbel.org/umbel#", "umbel-ac": "http://umbel.org/umbel/ac/", "umbel-sc": "http://umbel.org/umbel/sc/", "uniprot": "http://purl.uniprot.org/", "units": "http://dbpedia.org/units/", "usc": "http://www.rdfabout.com/rdf/schema/uscensus/details/100pct/", "v": "http://www.openlinksw.com/xsltext/", "vcard": "http://www.w3.org/2001/vcard-rdf/3.0#", "vcard2006": "http://www.w3.org/2006/vcard/ns#", "vi": "http://www.openlinksw.com/virtuoso/xslt/", "virt": "http://www.openlinksw.com/virtuoso/xslt", "virtcxml": "http://www.openlinksw.com/schemas/virtcxml#", "virtrdf": "http://www.openlinksw.com/schemas/virtrdf#", "void": "http://rdfs.org/ns/void#", "wb": "http://www.worldbank.org/", "wdrs": "http://www.w3.org/2007/05/powder-s#", "wf": "http://www.w3.org/2005/01/wf/flow#", "wfw": "http://wellformedweb.org/CommentAPI/", "wikicompany": "http://dbpedia.openlinksw.com/wikicompany/", "xf": "http://www.w3.org/2004/07/xpath-functions", "xfn": "http://gmpg.org/xfn/11#", "xhtml": "http://www.w3.org/1999/xhtml", "xhv": "http://www.w3.org/1999/xhtml/vocab#", "xi": "http://www.xbrl.org/2003/instance", "xml": "http://www.w3.org/XML/1998/namespace", "xn": "http://www.ning.com/atom/1.0", "xsd": "http://www.w3.org/2001/XMLSchema#", "xsl10": "http://www.w3.org/XSL/Transform/1.0", "xsl1999": "http://www.w3.org/1999/XSL/Transform", "xslwd": "http://www.w3.org/TR/WD-xsl", "y": "urn:yahoo:maps", "yago": "http://dbpedia.org/class/yago/", "yago-res": "http://mpii.de/yago/resource/", "yt": "http://gdata.youtube.com/schemas/2007", "zem": "http://s.zemanta.com/ns#"',
        '"?folio":{},"?image":{}');

-- DATAPERMISSIONS
INSERT INTO datapermission (data_id, user_id) VALUES (1, 'new_user');
INSERT INTO datapermission (data_id, user_id) VALUES (2, 'new_user');
INSERT INTO datapermission (data_id, user_id) VALUES (3, 'new_user');
INSERT INTO datapermission (data_id, user_id) VALUES (1, 'other_guy');
INSERT INTO datapermission (data_id, user_id) VALUES (2, 'other_guy');

-- VIEWS
INSERT INTO view (name, description, user_id, plugin_doc_id, history_doc_id)
    VALUES ('DBpedia', 'Setup for the DBpedia dataset.', 'new_user',
        '5667483eb292c9592888faac', '5667483eb292c9592888faad');
INSERT INTO view (name, description, user_id, plugin_doc_id, history_doc_id)
    VALUES ('Furman', 'All my furman stuff.', 'new_user',
        '5667485cb292c9f82788faac', '5667485cb292c9f82788faad');
INSERT INTO view (name, description, user_id, plugin_doc_id, history_doc_id)
    VALUES ('Furman', 'All my furman stuff.', 'other_guy',
        '566748a9b292c9fa2788faaa', '566748a9b292c9fa2788faab');
INSERT INTO view (name, description, user_id, plugin_doc_id, history_doc_id)
    VALUES ('UK', 'How to deal with UK Legislation.', 'other_guy',
        '566748e4b292c9fb2788faad', '566748e4b292c9fb2788faae');
