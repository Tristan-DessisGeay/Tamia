--
-- PostgreSQL database dump
--

-- Dumped from database version 15.1
-- Dumped by pg_dump version 15.1

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: tamia; Type: DATABASE; Schema: -; Owner: postgres
--

CREATE DATABASE tamia WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'French_France.1252';


ALTER DATABASE tamia OWNER TO postgres;

\connect tamia

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: produits; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.produits (
    id_s integer NOT NULL,
    id_p integer NOT NULL,
    libelle_p character varying(50),
    image_url_p text,
    event_p character varying(50),
    saving_p boolean DEFAULT false,
    frequence_p smallint DEFAULT 1,
    eventlist_p text,
    path_p text
);


ALTER TABLE public.produits OWNER TO postgres;

--
-- Name: produits_id_p_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.produits_id_p_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.produits_id_p_seq OWNER TO postgres;

--
-- Name: produits_id_p_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.produits_id_p_seq OWNED BY public.produits.id_p;


--
-- Name: sites; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sites (
    id_s integer NOT NULL,
    id_u integer NOT NULL,
    libelle_s character varying(50),
    image_url_s text,
    propertyid_s character varying(9)
);


ALTER TABLE public.sites OWNER TO postgres;

--
-- Name: sites_id_s_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sites_id_s_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sites_id_s_seq OWNER TO postgres;

--
-- Name: sites_id_s_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.sites_id_s_seq OWNED BY public.sites.id_s;


--
-- Name: utilisateurs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.utilisateurs (
    id_u integer NOT NULL,
    nom_u character varying(50),
    prenom_u character varying(50),
    email_u character varying(50),
    password_u character varying(50),
    image_profil_u text
);


ALTER TABLE public.utilisateurs OWNER TO postgres;

--
-- Name: utilisateurs_id_u_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.utilisateurs_id_u_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.utilisateurs_id_u_seq OWNER TO postgres;

--
-- Name: utilisateurs_id_u_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.utilisateurs_id_u_seq OWNED BY public.utilisateurs.id_u;


--
-- Name: produits id_p; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.produits ALTER COLUMN id_p SET DEFAULT nextval('public.produits_id_p_seq'::regclass);


--
-- Name: sites id_s; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sites ALTER COLUMN id_s SET DEFAULT nextval('public.sites_id_s_seq'::regclass);


--
-- Name: utilisateurs id_u; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.utilisateurs ALTER COLUMN id_u SET DEFAULT nextval('public.utilisateurs_id_u_seq'::regclass);


--
-- Data for Name: produits; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.produits (id_s, id_p, libelle_p, image_url_p, event_p, saving_p, frequence_p, eventlist_p, path_p) FROM stdin;
2	2	New T-shirt	assets/image/noisette.jpg	Atshirt	f	1	page_view;accountCreated	Tous les produits
1	1	T-shirt	https://piotavola.com/wp-content/uploads/2020/05/tshirt-2.jpg	Atshirt	f	2	page_view;scroll;user_engagement;purchase;session_start;first_visit;accountCreated	Tous les produits
\.


--
-- Data for Name: sites; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.sites (id_s, id_u, libelle_s, image_url_s, propertyid_s) FROM stdin;
1	1	E - Commerce Test	https://leflepourlescurieux.fr/wp-content/uploads/2017/07/lexique-des-vetements-et-des-accessoires-fle.jpg	347904942
2	2	E - Commerce Test	https://cdn-icons-png.flaticon.com/512/1818/1818806.png	347904942
\.


--
-- Data for Name: utilisateurs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.utilisateurs (id_u, nom_u, prenom_u, email_u, password_u, image_profil_u) FROM stdin;
1	Dessis-Geay	Tristan	tristan.dessisgeay@gmail.com	azerty	https://cdn-icons-png.flaticon.com/512/3135/3135715.png
2	Aviles	Loane	loane.aviles@gmail.com	azerty	https://img.freepik.com/vecteurs-premium/profil-avatar-femme-icone-ronde_24640-14048.jpg
\.


--
-- Name: produits_id_p_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

--SELECT pg_catalog.setval('public.produits_id_p_seq', 46, true);


--
-- Name: sites_id_s_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

--SELECT pg_catalog.setval('public.sites_id_s_seq', 18, true);


--
-- Name: utilisateurs_id_u_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

--SELECT pg_catalog.setval('public.utilisateurs_id_u_seq', 60, true);


--
-- Name: produits pk_produits; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.produits
    ADD CONSTRAINT pk_produits PRIMARY KEY (id_p);


--
-- Name: sites pk_sites; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sites
    ADD CONSTRAINT pk_sites PRIMARY KEY (id_s);


--
-- Name: utilisateurs pk_utilisateurs; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.utilisateurs
    ADD CONSTRAINT pk_utilisateurs PRIMARY KEY (id_u);


--
-- Name: possede_fk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX possede_fk ON public.sites USING btree (id_u);


--
-- Name: provient_de_fk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX provient_de_fk ON public.produits USING btree (id_s);


--
-- Name: produits fk_produits_provient__sites; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.produits
    ADD CONSTRAINT fk_produits_provient__sites FOREIGN KEY (id_s) REFERENCES public.sites(id_s) ON UPDATE RESTRICT ON DELETE CASCADE;


--
-- Name: sites fk_sites_possede_utilisat; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sites
    ADD CONSTRAINT fk_sites_possede_utilisat FOREIGN KEY (id_u) REFERENCES public.utilisateurs(id_u) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- PostgreSQL database dump complete
--

