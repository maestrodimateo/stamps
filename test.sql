DB::statement("ALTER TABLE agents ADD COLUMN searchtext TSVECTOR DEFAULT NULL");
DB::statement("UPDATE agents SET searchtext = to_tsvector('french', 'NOM' || ' ' || 'PRENOM' || ' ' || 'MATRICULE')");
DB::statement('CREATE INDEX searchtext_agents_gin ON agents USING GIN(searchtext)');
DB::statement("CREATE TRIGGER ts_searchtext_agent BEFORE INSERT OR UPDATE ON agents FOR EACH ROW EXECUTE PROCEDURE tsvector_update_trigger('searchtext', 'pg_catalog.french', 'NOM', 'PRENOM', 'MATRICULE')");
