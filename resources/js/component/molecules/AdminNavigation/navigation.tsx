import React, { useState } from 'react';
import { useLocation } from 'react-router';
import { Link } from 'react-router-dom';
import { AdminNavigationProps } from '../../../props/props';
import FAS from '../../atoms/Icon/FAS';

const AdminNavigationList: React.FC<React.PropsWithChildren<AdminNavigationProps>> = (
  props: AdminNavigationProps
): JSX.Element => {
  const [showEmergencySettings, setShowEmergencySettings] = useState(false);
  const [showSettingsEmergency, setShowSettingsemergency] = useState(false);
  const [showUnit, setShowUnit] = useState(false);
  const [showPage, setShowPage] = useState(false);
  const [showAktuelles, setShowAktuelles] = useState(false);
  const [showSettings, setShowSettings] = useState(false);
  const location = useLocation();

  const link = location.pathname;
  const emergencyMenu = ['/admin/emergency/overview'];
  const unitMenu = [
    '/admin/unitmember/overview',
    '/admin/member/overview',
    '/admin/vehicle/overview',
    '/admin/station/overview',
  ];
  const aktuellesMenu = [
    '/admin/termine/overview',
    '/admin/news/overview',
    '/admin/downloads/overview',
  ];
  const settingsemergencyMenu = [];
  const pageMenu = [
    '/admin/page/overview',
    '/admin/pageimages/overview',
    '/amin/placeholder/overview',
    '/amin/metatags/overview',
    '/amin/links/overview',
    '/amin/partner/overview',
  ];
  const settingsMenu = [
    '/admin/emergency/scenario',
    '/admin/users/overview',
    '/admin/todo/overview',
    '/admin/changelog/overview',
    '/admin/syslogs/overview',
  ];

  function checkMenuActive(link, now) {
    if (link === now.pathname) {
      return 'active';
    }
    return '';
  }

  function checkEmergencyMainMenuActive(emergencyMenu, location) {
    const link = '';
    if (emergencyMenu.includes(link)) {
      setShowEmergencySettings(true);
    }
  }

  function checkUnitMainMenuActive(unitMenu, location) {
    const link = '';
    if (unitMenu.includes(link)) {
      setShowUnit(true);
    }
  }

  function checkAktuellesMainMenuActive(aktuellesMenu, location) {
    const link = '';
    if (aktuellesMenu.includes(link)) {
      setShowAktuelles(true);
    }
  }

  function checkSettingsEmergencyMainMenuActive(settingsEmergencyMenu, location) {
    const link = '';
    if (settingsEmergencyMenu.includes(link)) {
      setShowSettingsemergency(true);
    }
  }

  function checkSettingsMainMenuActive(settingsMenu, location) {
    const link = '';
    if (settingsMenu.includes(link)) {
      setShowSettings(true);
    }
  }

  function checkPageMainMenuActive(pageMenu, location) {
    const link = '';
    if (pageMenu.includes(link)) {
      setShowPage(true);
    }
  }

  return (
    <>
      <li className={checkMenuActive('/admin', location)}>
        <Link to="/admin/">
          <FAS className="home" />
          <span className="title">Home</span>
        </Link>
      </li>
      <li className={checkMenuActive('/admin/emergency/overview', location)}>
        <Link to="/admin/emergency/overview">
          <FAS className="fire" />
          <span className="title">Einsätze</span>
        </Link>
      </li>
      <li className={showEmergencySettings ? 'open' : ''}>
        <button onClick={() => setShowEmergencySettings(!showEmergencySettings)}>
          <FAS className="receipt" />
          <span className="title">Einsatzverwalten</span> <span className=" arrow" />
        </button>
        <ul className={showEmergencySettings ? 'sub-menu show-submenu' : 'sub-menu'}>
          <li
            className={
              checkMenuActive('/admin/units/overview', location) +
              checkEmergencyMainMenuActive(emergencyMenu, location)
            }
          >
            <Link to="/admin/units/overview">Einheiten</Link>
          </li>
          <li
            className={
              checkMenuActive('/admin/emergencykey/overview', location) +
              checkEmergencyMainMenuActive(emergencyMenu, location)
            }
          >
            <Link to="/admin/emergencykey/overview">Begriffe</Link>
          </li>
          <li
            className={
              checkMenuActive('/admin/missionscenario/overview', location) +
              checkEmergencyMainMenuActive(emergencyMenu, location)
            }
          >
            <Link to="/admin/missionscenario/overview">Leitstellenbegriffe</Link>
          </li>
        </ul>
      </li>
      <li className={showAktuelles ? 'open' : ''}>
        <button onClick={() => setShowAktuelles(!showAktuelles)}>
          <FAS className="newspaper" />
          <span className="title">Aktuelles</span> <span className=" arrow" />
        </button>
        <ul className={showAktuelles ? 'sub-menu show-submenu' : 'sub-menu'}>
          <li
            className={
              checkMenuActive('/admin/news/overview', location) +
              checkAktuellesMainMenuActive(aktuellesMenu, location)
            }
          >
            <Link to="/admin/news/overview">News</Link>
          </li>
          <li
            className={
              checkMenuActive('/admin/termine/overview', location) +
              checkAktuellesMainMenuActive(aktuellesMenu, location)
            }
          >
            <Link to="/admin/termine/overview">Termine</Link>
          </li>
          <li
            className={
              checkMenuActive('/admin/downloads/overview', location) +
              checkAktuellesMainMenuActive(aktuellesMenu, location)
            }
          >
            <Link to="/admin/downloads/overview">Downloads</Link>
          </li>
        </ul>
      </li>
      <li className={showUnit ? 'open' : ''}>
        <button onClick={() => setShowUnit(!showUnit)}>
          <FAS className="box-archive" />
          <span className="title">Wehr</span> <span className=" arrow" />
        </button>
        <ul className={showUnit ? 'sub-menu show-submenu' : 'sub-menu'}>
          <li
            className={
              checkMenuActive('/admin/unitmember/overview', location) +
              checkUnitMainMenuActive(unitMenu, location)
            }
          >
            <Link to="/admin/unitmember/overview">Wehrführung</Link>
          </li>
          <li
            className={
              checkMenuActive('/admin/member/overview', location) +
              checkUnitMainMenuActive(unitMenu, location)
            }
          >
            <Link to="/admin/member/overview">Mitglieder</Link>
          </li>
          <li
            className={
              checkMenuActive('/admin/vehicle/overview', location) +
              checkUnitMainMenuActive(unitMenu, location)
            }
          >
            <Link to="/admin/vehicle/overview">Fahrzeuge</Link>
          </li>
          <li
            className={
              checkMenuActive('/admin/station/overview', location) +
              checkUnitMainMenuActive(unitMenu, location)
            }
          >
            <Link to="/admin/station/overview">Wachen</Link>
          </li>
        </ul>
      </li>
      <li className={showPage ? 'open' : ''}>
        <button onClick={() => setShowPage(!showPage)}>
          <FAS className="receipt" />
          <span className="title">Seiten</span> <span className=" arrow" />
        </button>
        <ul className={showPage ? 'sub-menu show-submenu' : 'sub-menu'}>
          <li
            className={
              checkMenuActive('/admin/links/overview', location) +
              checkPageMainMenuActive(pageMenu, location)
            }
          >
            <Link to="/admin/links/overview">Link</Link>
          </li>
          <li
            className={
              checkMenuActive('/admin/partner/overview', location) +
              checkPageMainMenuActive(pageMenu, location)
            }
          >
            <Link to="/admin/partner/overview">Partner</Link>
          </li>
          <li
            className={
              checkMenuActive('/admin/page/overview', location) +
              checkPageMainMenuActive(pageMenu, location)
            }
          >
            <Link to="/admin/page/overview">Seiten</Link>
          </li>
          <li
            className={
              checkMenuActive('/admin/pageimages/overview', location) +
              checkPageMainMenuActive(pageMenu, location)
            }
          >
            <Link to="/admin/pageimages/overview">Seitenbilder</Link>
          </li>
          <li
            className={
              checkMenuActive('/admin/placeholder/overview', location) +
              checkPageMainMenuActive(pageMenu, location)
            }
          >
            <Link to="/admin/placeholder/overview">Platzhalter</Link>
          </li>
          <li
            className={
              checkMenuActive('/admin/metatags/overview', location) +
              checkPageMainMenuActive(pageMenu, location)
            }
          >
            <Link to="/admin/metatags/overview">Metatags</Link>
          </li>
        </ul>
      </li>
      <li className={showSettings ? 'open' : ''}>
        <button onClick={() => setShowSettings(!showSettings)}>
          <FAS className="tools" />
          <span className="title">Systemeinstellungen</span> <span className=" arrow" />
        </button>
        <ul className={showSettings ? 'sub-menu show-submenu' : 'sub-menu'}>
          <li
            className={
              checkMenuActive('/admin/emergency/scenario', location) +
              checkSettingsMainMenuActive(settingsMenu, location)
            }
          >
            <Link to="/admin/emergency/scenario">Emergency Scenarios</Link>
          </li>
          <li
            className={
              checkMenuActive('/admin/todo/overview', location) +
              checkSettingsMainMenuActive(settingsMenu, location)
            }
          >
            <Link to="/admin/todo/overview">Todo</Link>
          </li>
          <li
            className={
              checkMenuActive('/admin/changelog/overview', location) +
              checkSettingsMainMenuActive(settingsMenu, location)
            }
          >
            <Link to="/admin/changelog/overview">Changelog</Link>
          </li>
          <li
            className={
              checkMenuActive('/admin/syslogs/overview', location) +
              checkSettingsMainMenuActive(settingsMenu, location)
            }
          >
            <Link to="/admin/syslogs/overview">Syslogs</Link>
          </li>
          <li
            className={
              checkMenuActive('/admin/users/overview', location) +
              checkSettingsMainMenuActive(settingsMenu, location)
            }
          >
            <Link to="/admin/users/overview">Benutzer</Link>
          </li>
        </ul>
      </li>
    </>
  );
};
export default AdminNavigationList;
