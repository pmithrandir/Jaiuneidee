CHANGELOG
=========

A [BC BREAK] means the update will break the project for many reasons :

* new mandatory configuration
* new dependencies
* class refactoring

### [BC BREAK] 2013-12-30

* Configuration structure for flashmessage has changed to be more generic, this is what is expected now:

```
sonata_core:
    flashmessage:
        error:
            # You may now override the css class used for rendering the message
            css_class: danger
            types:
                error:
                    domain: SonataCoreBundle
                sonata_error:
                    domain: SonataCoreBundle
        # This is templated, you may add as many flash messages type you want
        warn:
            # You may now override the css class used for rendering the message, optional in the configuration
            css_class: warning
            types:
                warn:
                    domain: SonataCoreBundle
                sonata_warn:
                    domain: SonataCoreBundle
        # ...
```