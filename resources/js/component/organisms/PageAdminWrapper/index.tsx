import { useEffect, useState } from 'react';
import { PageAdminWrapperProps } from '../../../props/props';
import ButtonFAS from '../../atoms/Buttons/ButtonFAS';
import SyncActive from '../../atoms/SyncActive';
import AdminNavigation from '../../molecules/AdminNavigation';
import AlertInfoErrorLine from '../../molecules/AlertInfoLine/Error';
import AlertInfoInfoLine from '../../molecules/AlertInfoLine/Info';
import ShadowArea from '../../molecules/ShadowArea';
import AdminHeader from '../AdminHeader';
import BackToTop from '../BackToTop';
import ErrorBoundary from '../errorboundary';
import { useAuth } from '../../useHooks/useAuth';

const PageAdminWrapper: React.FC<React.PropsWithChildren<PageAdminWrapperProps>> = (
  props: PageAdminWrapperProps
): JSX.Element => {
  const [showMessage, setShowMessage] = useState<boolean>(false);
  const [clearCache, setClearCache] = useState<boolean>(false);
  const [showCacheInfo, setShowCacheInfo] = useState<string>('');
  const [errorMessage, setErrorMessage] = useState<string>('');
  const [getShowShadow, setShowShadow] = useState<boolean>(false);
  const { logout } = useAuth({
    middleware: 'auth',
  });

  function removeMessage() {
    setShowMessage(false);
    setErrorMessage('');
    setShowCacheInfo('');
  }

  useEffect(() => {
    async function fetchMyApi() {
      let response = await fetch('/api/clearcache/0');
      response = await response.json();
      setErrorMessage('');
      setShowCacheInfo('Cache geleert!');
      setShowMessage(true);
      setTimeout(() => removeMessage(), 1000);
      setClearCache(false);
    }

    fetchMyApi();
  }, [clearCache]);

  function makeClearCache(e) {
    e.preventDefault();
    setClearCache(true);
  }

  return (
    <ErrorBoundary>
      <ShadowArea show_shadow={getShowShadow} />
      {typeof props.header !== 'undefined' ? (
        <AdminHeader header={props.header} />
      ) : (
        <AdminHeader header={undefined} />
      )}
      <div className="page-container row-fluid">
        <div className="page-sidebar" id="main-menu">
          <div className="scroll-wrapper page-sidebar-wrapper scrollbar-dynamic">
            <div
              className="page-sidebar-wrapper scrollbar-dynamic scroll-content scroll-scrolly_visible"
              id="main-menu-wrapper"
            >
              <ErrorBoundary>
                <AdminNavigation location={props.location} />
              </ErrorBoundary>
            </div>
          </div>
        </div>
        <div className="footer-widget">
          <ButtonFAS title="" onClick={e => logout()} FAclassName="arrow-right-from-bracket" />
          <ButtonFAS title="Cache leeren" onClick={e => makeClearCache(e)} FAclassName="toilet" />
          <SyncActive />
          <div className="progress transparent progress-small no-radius no-margin" />
          <div className="pull-right" />
        </div>
        <div className="page-content">
          <div className="clearfix" />
          <div className="content">
            <div className="container cont_area">
              {showMessage === true ? <AlertInfoInfoLine text={showCacheInfo} /> : ''}
              {errorMessage !== '' ? <AlertInfoErrorLine text={errorMessage} /> : ''}
              {props.children}
            </div>
          </div>
        </div>
      </div>
      <BackToTop />
    </ErrorBoundary>
  );
};
export default PageAdminWrapper;
